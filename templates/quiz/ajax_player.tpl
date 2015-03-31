<div class="player {TEAM_TYPE}">
	<div class="champion_icon" style="background-image:url(http://ddragon.leagueoflegends.com/cdn/5.6.1/img/champion/{CHAMPION_KEY}.png)">
	</div>

	<div class="items">
		{if ITEM0_ITEM_ID}
			<div class="item_icon" style="background-image:url(http://ddragon.leagueoflegends.com/cdn/5.6.1/img/item/{ITEM0_ITEM_ID}.png);"></div>
		{else}
			<div class="item_icon no_icon"></div>
		{/if}

		{if ITEM1_ITEM_ID}
			<div class="item_icon" style="background-image:url(http://ddragon.leagueoflegends.com/cdn/5.6.1/img/item/{ITEM1_ITEM_ID}.png);"></div>
		{else}
			<div class="item_icon no_icon"></div>
		{/if}

		{if ITEM2_ITEM_ID}
			<div class="item_icon" style="background-image:url(http://ddragon.leagueoflegends.com/cdn/5.6.1/img/item/{ITEM2_ITEM_ID}.png);"></div>
		{else}
			<div class="item_icon no_icon"></div>
		{/if}
		<div class="items_clear"></div>

		{if ITEM3_ITEM_ID}
			<div class="item_icon" style="background-image:url(http://ddragon.leagueoflegends.com/cdn/5.6.1/img/item/{ITEM3_ITEM_ID}.png);"></div>
		{else}
			<div class="item_icon no_icon"></div>
		{/if}

		{if ITEM4_ITEM_ID}
			<div class="item_icon" style="background-image:url(http://ddragon.leagueoflegends.com/cdn/5.6.1/img/item/{ITEM4_ITEM_ID}.png);"></div>
		{else}
			<div class="item_icon no_icon"></div>
		{/if}
		
		{if ITEM5_ITEM_ID}
			<div class="item_icon" style="background-image:url(http://ddragon.leagueoflegends.com/cdn/5.6.1/img/item/{ITEM5_ITEM_ID}.png);"></div>
		{else}
			<div class="item_icon no_icon"></div>
		{/if}
	</div>
</div>