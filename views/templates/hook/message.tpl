{if $id == 2 }
	<div class="container">
{/if}
<div id="owm-message-{$id}" style="background-color: white; padding: 20px; margin-bottom: 20px;box-shadow: 0px 0px 20px rgba(0,0,0,0.1);">
	
	<span>{$message nofilter}</span>
	
	{if $hideable }
		<button class"btn {$style_caption}" onclick="document.getElementById('owm-message-{$id}').style.display = 'none';">{$caption}</button>
	{/if}
</div>
{if $id == 2 }
	</div>
{/if}