/*
* Code Insert eg Adsense
* Forked from [codeinsert Embed Plugin]
*
* @author Zein Miftah <zeinmiftah@gmail.com>
* @version 1.0.0
*/
( function() {
	CKEDITOR.plugins.add( 'codeinsert',
	{
		lang: [ 'en' ],
		init: function( editor )
		{
			editor.addCommand( 'codeinsert', new CKEDITOR.dialogCommand( 'codeinsert', {
				allowedContent: null
			}));

			editor.ui.addButton( 'codeinsert',
			{
				label : editor.lang.codeinsert.button,
				toolbar : 'insert',
				command : 'codeinsert',
				icon : this.path + 'images/icon.png'
			});

			CKEDITOR.dialog.add( 'codeinsert', function ( instance )
			{
				var code;

				return {
					title : editor.lang.codeinsert.title,
					contents :
						[{
							id : 'codeinsertPlugin',
							minWidth: 500,
              minHeight: 250,
							resizable: CKEDITOR.DIALOG_RESIZE_BOTH,
							elements : [
								{
									id : 'txtCode',
									type : 'textarea',
									rows: 6,
									label : editor.lang.codeinsert.txtCode,
									autofocus : 'autofocus',
									validate : function ()
									{
										if ( this.isEnabled() )
										{
											if ( !this.getValue() )
											{
												alert( editor.lang.codeinsert.noCode );
												return false;
											}
											else
											if ( this.getValue().length === 0 || this.getValue().indexOf( '//' ) === -1 )
											{
												alert( editor.lang.codeinsert.invalidCode );
												return false;
											}
										}
									}
								}
							]
						}
					],
					onOk: function()
					{
						var content = this.getValueOf( 'codeinsertPlugin', 'txtCode' );
						var instance = this.getParentEditor();

						instance.insertHtml( content );
					}
				};
			});
		}
	});
})();