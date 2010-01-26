{include file='header.tpl'}

<form action='processDistrib.php' method='post'>
<div id='floater'>
	<p>Please review the suggestions below and click the "Looks good" button when ready.</p>
	<table>
{section name=n loop=$loot_results}
		<tr>
			<td class='loot'><img src='lootImages/{$loot_results[n].loot|regex_replace:"/\'/":""|regex_replace:"/ /":"_"|lower}.gif' alt="{$loot_results[n].loot}" title="{$loot_results[n].loot}" class='loot_item'></td>
			<td class='name'><select name="{$loot_results[n].loot}">{section name=m loop=$loot}{if $loot[m]->throughSewer}<option value='{$loot[m]->name}'{if $loot[m]->name==$loot_results[n].name} selected{/if}>{$loot[m]->name}{if $loot[m]->name==$loot_results[n].name} (suggested){/if}</option>{/if}{/section}</select></td>
		</tr>
{/section}
	</table>
	<div id='filler'><input type='submit' name='submit' value='Looks good!'></div>
</div>

<table id='loot_results' cellpadding='0' cellspacing='0'>
{section name=n loop=$loot}
	<tr class='loot_entry{if $smarty.section.n.index%2 == 1} shaded{/if}{if $smarty.section.n.first} top{/if}{if !$loot[n]->throughSewer} ineligible{/if}'>
		<td class='name'>{$loot[n]->name}</td>
		<td class='rank'>{math x=$loot[n]->turns y=$loot[n]->oldTurns equation="x+y"} <span class='fade'>({$loot[n]->turns})</span></td>
		<td class='text'>{if !$loot[n]->gotSomething}<ul>{foreach from=$loot[n]->lootResults item=i}<li>{$i}</li>{/foreach}</ul>{else}&nbsp;{/if}</td>
	</tr>
{/section}
</table>
</form>

{include file='footer.tpl'}