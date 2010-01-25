{include file='header.tpl'}

<div id="tab_container" style="margin: 0 0 10px 0;">
<div class="tabber">
	<div class="tabbertab" title="Current Points">
{if count($divers)==0}There are no points allocated as of yet.{else}
		<div class='diver header'><div class='name'>Diver Name</div><div class='points'>Saved Points</div><div class='activeDate'>Date of Last Activity</div></div>
{foreach from=$divers item=m name=divers}		<div class='diver{if $smarty.foreach.divers.index%2 == 1} shaded{/if}{if $smarty.foreach.divers.last} last{/if}'><div class='name'>{$m->name}</div><div class='points'>{$m->oldTurns}</div><div class='activeDate'>{$m->lastActiveDate}</div></div>
{/foreach}
{/if}
	</div>
	<div class="tabbertab" title="Settings">
		The settings are not yet set up.
<!--{$settings}-->
	</div>
	<div class="tabbertab" title="Archive">
		The archive is not yet set up.
<!--{$archive}-->
	</div>
</div>
</div>

<div id='distrib_form'>
	<form action='showResults.php' method='post' enctype='multipart/form-data'>
	<h3>Dungeon log:</h3>
	<textarea name='log_raw'></textarea>
	<h3>Loot list:</h3>
	<textarea name='loot_raw'></textarea>
	<h3>Wish list:</h3>
	<input type="file" name="wish_list" size="35">
	<div id='mySubmit'>
		<input type='submit' name='submit' value='Show me the loot!'>
	</div>
	</form>
</div>

{include file='footer.tpl'}
