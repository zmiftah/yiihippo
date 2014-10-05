/**
 * Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
  config.skin = 'moono-light';
  config.allowedContent = true;

  config.extraPlugins = 'image,youtube,codeinsert,wordcount';

  config.youtube_width = '640';
  config.youtube_height = '480';
  config.youtube_older = false;

  config.wordcount = {
    showWordCount: true,
    showCharCount: true,
    countHTML: false,
    charLimit: 'unlimited',
    wordLimit: 'unlimited'
	};

    // Default setting.
	config.toolbarGroups = [
		{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		// { name: 'forms' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'links' },
		{ name: 'insert',      groups: [ 'insert', 'youtube' ] },
		'/',
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'tools' },
		{ name: 'others' }
	];
};

