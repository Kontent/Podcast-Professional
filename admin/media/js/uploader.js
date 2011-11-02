var PodcastPro = new Class({

	initialize: function() {
	}

});

PodcastPro.Uploader = new Class({

	options: {
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		url: '',

		// widget specific
		dragdrop : true,
		multiple_queues: true, // re-use widget by default

		buttons: {
			browse: true,
			start: true,
			stop: true
		},
		autostart: true,
		max_file_count: 0 // unlimited
	},

	contents_bak: '',
	FILE_COUNT_ERROR: -9001,

	initialize: function(name, options) {
		var self = this, id, uploader;

		//this.options = Object.merge(this.options, options); // MooTools 1.3
		this.options = $merge(this.options, options);

		this.element = document.id(name);

		id = this.element.get('id');
		if (!id) {
			id = plupload.guid();
			this.element.set('id', id);
		}
		this.id = id;

		this.contents_bak = this.element.get('html');
		this._render(name);

		// container, just in case
		this.container = this.element.getElement('.upload-container').set('id', id + '_container');

		// list of files, may become sortable
		this.filelist = this.container.getElement('.upload-filelist-files').set({
			id: id + '_filelist',
			unselectable: 'on'
		});

		// buttons
		this.browse_button = this.container.getElement('.upload-button-add').set('id', id + '_browse');
		this.start_button = this.container.getElement('.upload-button-start').set('id', id + '_start');
		this.stop_button = this.container.getElement('.upload-button-stop').set('id', id + '_stop');

		// counter
		this.counter = this.element.getElement('.upload-count').set({
			id: id + '_count',
			name: id + '_count'
		});

		// initialize uploader instance
//		uploader = this.uploader = new plupload.Uploader(Object.merge({ // MooTools 1.3
		uploader = this.uploader = new plupload.Uploader($merge({
			container: id,
			browse_button: id + '_browse'
		}, this.options));

		uploader.bind('Init', function(up, res) {
			if (self.uploader.features.dragdrop && self.options.dragdrop) {
				self._enableDragAndDrop();
			}

			self.container.set('title', 'Using runtime: ' + (self.runtime = res.runtime));

			self.start_button.addEvent('click', function(e) {
				self.start();
				e.preventDefault();
			});

			self.stop_button.addEvent('click', function(e) {
				self.stop();
				e.preventDefault();
			});
		});

		uploader.init();

		// check if file count doesn't exceed the limit
		if (this.options.max_file_count) {
			uploader.bind('FilesAdded', function(up, selectedFiles) {
				var removed = [], selectedCount = selectedFiles.length;
				var extraCount = up.files.length + selectedCount - self.options.max_file_count;

				if (extraCount > 0) {
					removed = selectedFiles.splice(selectedCount - extraCount, extraCount);
					//self.uploader.splice(selectedCount - extraCount, extraCount);

					up.trigger('Error', {
						code : self.FILE_COUNT_ERROR,
						message : 'File count error.',
						file : removed
					});
				}
			});
		}

		uploader.bind('FilesAdded', function(up, files) {
			if (self.options.autostart) {
				self.start();
			}
		});

		uploader.bind('FilesRemoved', function(up, files) {
		});

		uploader.bind('QueueChanged', function() {
			self._updateFileList();
			self._handleState();
		});

		uploader.bind('StateChanged', function() {
			self._handleState();
		});

		uploader.bind('UploadFile', function(up, file) {
			self._handleFileStatus(file);
		});

		uploader.bind('ChunkUploaded', function(up, file, result) {
			self._handleErrors(file, result);
		});

		uploader.bind('FileUploaded', function(up, file, result) {
			self._handleErrors(file, result);
			self._handleFileStatus(file);
		});

		uploader.bind('UploadProgress', function(up, file) {
			// Set file specific progress
			self.element.getElement('#' + file.id + ' .upload-file-status').set('html', file.percent + '%');

			self._handleFileStatus(file);
			self._updateTotalProgress();
		});

		uploader.bind('UploadComplete', function(up, files) {
		});

		uploader.bind('Error', function(up, err) {
			var file = err.file, message, details;
			
			if (file) {
				message = '<strong>' + err.message + '</strong>';
				details = err.details;

				if (details) {
					message += " <br /><i>" + err.details + "</i>";
				} else {
					switch (err.code) {
						case plupload.FILE_EXTENSION_ERROR:
							details = "File: %s".replace('%s', file.name);
							break;
						
						case plupload.FILE_SIZE_ERROR:
							details = "File: %f, size: %s, max file size: %m".replace(/%([fsm])/g, function($0, $1) {
								switch ($1) {
									case 'f': return file.name;
									case 's': return file.size;
									case 'm': return plupload.parseSize(self.options.max_file_size);
								}
							});
							break;

						case self.FILE_COUNT_ERROR:
							details = "Upload element accepts only %d file(s) at a time. Extra files were stripped."
								.replace('%d', self.options.max_file_count);
							break;

						case plupload.IMAGE_FORMAT_ERROR :
							details = plupload.translate('Image format either wrong or not supported.');
							break;

						case plupload.IMAGE_MEMORY_ERROR :
							details = plupload.translate('Runtime ran out of available memory.');
							break;

						case plupload.IMAGE_DIMENSIONS_ERROR :
							details = plupload.translate('Resoultion out of boundaries! <b>%s</b> runtime supports images only up to %wx%hpx.').replace(/%([swh])/g, function($0, $1) {
								switch ($1) {
									case 's': return up.runtime;
									case 'w': return up.features.maxWidth;	
									case 'h': return up.features.maxHeight;
								}
							});
							break;

						case plupload.HTTP_ERROR:
							details = "Upload URL might be wrong or doesn't exist";
							break;
					}
					message += " <br /><i>" + details + "</i>";
				}

				self.notify('error', message);
			}
		});
	},

	start: function() {
		this.uploader.start();
	},

	stop: function() {
		this.uploader.stop();
	},

	getFile: function(id) {
		var file;

		if (typeof id === 'number') {
			file = this.uploader.files[id];
		} else {
			file = this.uploader.getFile(id);
		}
		return file;
	},

	removeFile: function(id) {
		var file = this.getFile(id);
		if (file) {
			this.uploader.removeFile(file);
		}
	},

	clearQueue: function() {
		this.uploader.splice();
	},

	getUploader: function() {
		return this.uploader;
	},

	refresh: function() {
		this.uploader.refresh();
	},

	notify: function(type, message) {
		var popup = new Element('div', {
			'html': '<div class="upload-icon upload-close" title="'+'Close'+'"></div>' +
					'<p><span class="upload-icon"></span>'+message+'</p>'
		});

		popup.addClass('upload-' + (type === 'error' ? 'error' : 'highlight'));
		popup.getElements('p .upload-icon').addClass('upload-' + (type === 'error' ? 'alert' : 'info'));
		popup.getElements('.upload-close').addEvent('click', (function(e) {
			popup.destroy();
			e.preventDefault();
		}));

		this.container.grab(popup, 'top');
	},

	_render: function(name) {
		document.id(name).set('html', 
			'<div class="upload-container">' +

			'<div class="upload-filelist-container">' +

			'<table class="upload-filelist">' +
			'<tr class="upload-filelist-header">' +
			'<th class="upload-file-name">'+'File Name'+'</th>' +
			'<th class="upload-file-status">'+'Status'+'</th>' +
			'<th class="upload-file-size">'+'Size'+'</th>' +
			'<th class="upload-file-action">&nbsp;</th>' +
			'</tr>' +
			'</table>' +

			'<div class="upload-scroll">' +

			'<table class="upload-filelist-files"></table>' +

			'</div>' +
			'<div class="upload-status">' +

			'<table class="upload-filelist">' +
			'<tr class="upload-filelist-footer">' +
			'<td class="upload-file-name">' +
			'<div class="upload-upload-status"></div>' +
			'</td>' +
			'<td class="upload-file-status"><span class="upload-total-status">0%</span></td>' +
			'<td class="upload-file-size"><span class="upload-total-file-size">'+'0kb'+'</span></td>' +
			'<td class="upload-file-action"></td>' +
			'</tr>' +
			'</table>' +

			'</div>' +
			'<div class="upload-buttons">' +
			'<a class="button upload-button-add">'+'Add Files'+'</a>&nbsp;' +
			'<a class="button upload-button-start upload-hidden">'+'Start Upload'+'</a>&nbsp;' +
			'<a class="button upload-button-stop upload-hidden">'+'Stop Upload'+'</a>&nbsp;' +
			'</div>' +
			'</div>' +
			'</div>' +
			'<input class="upload-count" value="0" type="hidden">' +
			'</div>');
	},

	_handleErrors: function(file, result) {
		var self = this, uploader = this.uploader;
		var response = JSON.decode(result.response, true);
		if (!response || !response.success) {
			file.status = plupload.FAILED;

			self.notify('error', (response && response.error ? response.error : 'Unknown response error!') + '<br />File: '+file.name);
		}
	},

	_handleState: function() {
		var self = this, uploader = this.uploader;

		if (uploader.state === plupload.STARTED) {
			
			self.start_button.addClass('upload-hidden');
			if (this.options.buttons.stop === true) self.stop_button.removeClass('upload-hidden');
			
		} else {
			
			self.stop_button.addClass('upload-hidden');
			if (this.options.buttons.start === true && uploader.total.queued > 0) self.start_button.removeClass('upload-hidden');
			self._updateFileList();
		}
	},
	
	_handleFileStatus: function(file) {
		var actionClass, iconClass;

		switch (file.status) {
			case plupload.DONE: 
				actionClass = 'upload-file upload-done';
				iconClass = 'upload-icon upload-check';
				break;
			
			case plupload.FAILED:
				actionClass = 'upload-file upload-failed';
				iconClass = 'upload-icon upload-alert';
				break;

			case plupload.QUEUED:
				actionClass = 'upload-file upload-delete';
				iconClass = 'upload-icon upload-minus';
				break;

			case plupload.UPLOADING:
				actionClass = 'upload-file upload-uploading';
				iconClass = 'upload-icon upload-arrow';
				break;
		}

		var entry = document.id(file.id);
		if (entry) entry.set('class', actionClass).getElements('.upload-icon').set('class', iconClass);
	},

	_updateTotalProgress: function() {
		var uploader = this.uploader;

		this.element.getElement('.upload-total-status').set('html', uploader.total.percent + '%');

		this.element.getElement('.upload-upload-status').set('text',
			'Uploaded %d/%d files'.replace('%d/%d', uploader.total.uploaded+'/'+uploader.files.length)
		);
		if (uploader.total.queued === 0) {
			this.browse_button.set('text', 'Add Files');
		} else {
			this.browse_button.set('text', '%d files queued'.replace('%d', uploader.total.queued));
		}
	},

	_updateFileList: function() {
		var self = this, uploader = this.uploader, filelist = this.filelist, 
			count = 0, 
			id, prefix = this.id + '_',
			fields;
			
		filelist.empty();

		Array.each(uploader.files, function(file) {
			fields = '';
			id = prefix + count;

			if (file.status === plupload.DONE) {
				if (file.target_name) {
					fields += '<input type="hidden" name="' + id + '_tmpname" value="'+plupload.xmlEncode(file.target_name)+'" />';
				}
				fields += '<input type="hidden" name="' + id + '_name" value="'+plupload.xmlEncode(file.name)+'" />';
				fields += '<input type="hidden" name="' + id + '_status" value="' + (file.status === plupload.DONE ? 'done' : 'failed') + '" />';

				count++;
				self.counter.set('value', count);
			}

			var html = new Element('tr', {
				class: 'upload_file', 
				id: file.id, 
				html: '<td class="upload-file-name"><span>' + file.name + '</span></td>' +
				'<td class="upload-file-status">' + file.percent + '%</td>' +
				'<td class="upload-file-size">' + plupload.formatSize(file.size) + '</td>' +
				'<td class="upload-file-action"><div class="upload-icon" title="'+'Remove File'+'"></div>' + fields + '</td>'
				}
			);
			filelist.grab(html);

			self._handleFileStatus(file);

			$$('#' + file.id + ' .upload-icon').addEvent('click', function(e) {
				document.id(file.id).destroy();
				uploader.removeFile(file);
				self._handleState();
				if (file.status == plupload.UPLOADING) {
					self.stop();
					self.start();
				}
				e.preventDefault();
			});
		});

		self.element.getElement('.upload-total-file-size').set('html',plupload.formatSize(uploader.total.size));

		if (uploader.features.dragdrop && uploader.settings.dragdrop) {
			// Re-add drag message if needed
			var drag = new Element('tr', {
				html: '<td colspan="4" class="upload-droptext">' + "Drag files here." + '</td>'
				}
			);
			this.filelist.grab(drag);
		}
		self._updateTotalProgress();
	},
	
	_enableDragAndDrop: function() {
		this._updateFileList();
		this.filelist.getParent().set('id', this.id + '_dropbox');
		this.uploader.settings.drop_element = this.options.drop_element = this.id + '_dropbox';
	}

});
