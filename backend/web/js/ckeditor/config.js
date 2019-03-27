/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.filebrowserUploadUrl = '/article/upload-image';
    config.filebrowserImageUploadUrl = '/article/upload-image';
    config.filebrowserImageBrowseLinkUrl = '/article/upload-image';
    config.toolbarGroups = [
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'about', groups: [ 'about' ] },
        { name: 'document', groups: [ 'mode' ] }
    ];
    config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,Redo,Undo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField,CopyFormatting,RemoveFormat,BidiRtl,BidiLtr,Language,Flash,SpecialChar,PageBreak,Iframe,Styles,ShowBlocks,About,ImageButton';
};
