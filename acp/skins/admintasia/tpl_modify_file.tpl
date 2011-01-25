
					<h3>{lang.tplmodnow} {$filename}</h3>
				<form action="javascript: savetpl();"  method="POST" id="form">
                                <input type="hidden" value="{$tpl}" name="filelink" id="filelink" />
                                <input type="hidden" value="{$filename}" name="fname" id="fname" />
                        	<textarea rows="1" cols="1" name="notes" id="notes">{$filecontent}</textarea>
                            <input type="submit" value="{lang.submit}" />
                        
                    </form>
               
				
<br />