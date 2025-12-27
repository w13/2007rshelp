<?php
require('backend.php');
start_page(1,'The Guide to Managing OSRS RuneScape Help\'s Databases');
?>

<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <u>The Guide to Managing OSRS RuneScape Help's Databases</u></div>
<hr class="main" noshade="noshade" />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">
<div class="title1">Table of Contents</div>
<ul class="toc">
<li><a href="#1">Item Database</a></li>
<li><a href="#2">Monster Database</a></li>
<li><a href="#3">Calculators</a></li>
</ul>

<br />
<div class="notice">When creating a new entry, make sure the item/monster isn't already in the database.  You should generate several searches before you come to this conclusion.  Sometimes it won't be named exactly as you expect it to be.  Make sure it doesn't exist before you make it.</div>


<a name="1"></a>
<div class="title1">Item Database</div>
<p>Managing the Item Database is a fairly simple task, but with these few key tips, you can still make sure you're working on it properly.</p>
<p>Currently, there are three types of items that you must concern yourself with.  When you create a new item, you'll need to edit the type, submit, and then put the information in the entry, because different types offer different fields.</p>
<p><b>Armour/Weapons:</b> This type is reserved for all items that one might use in combat.  Just because you can wear it, that doesn't mean it's armour.  For example, a Frog helmet is not armour.  A Torag's help is.</p>
<p><b>Quest Items:</b> All items that are used in a quest go here.  Items that one receives after a quest or can use after a quest are not quest items.  For example, a dragon scimitar is not a quest item.</p>
<p><b>Miscellaneous Items:</b> This category encompasses all items that don't fit into the first two.  Anything not used during a quest that one would not generally fight with goes here.</p>
<p>Below is a list of all the fields in the Item Database.  Though they will vary depending on what type you're editing, you fill them out the same way.  A <span style="color:red;">*</span> denotes that the field is necessary to be marked complete.</p>
<ol>
<li><span style="color:red;">*</span><b>Name:</b> Only the first word of the name of an Item Database entry is to be capitalized.  The only exceptions are special words or proper nouns.  For example, "Wine of Zamorak".</li>
<li><span style="color:red;">*</span><b>Image:</b> Do not fill this out.  Upload your image and the manager that moves it will fill in this field.</li>
<li><span style="color:red;">*</span><b>Type:</b> Select the appropriate type (as described before) from the drop down menu.</li>
<li><span style="color:red;">*</span><b>Equipment Type:</b> Select where the item goes on your body.  If you cannot wear it, leave it as "Unset".</li>
<li><span style="color:red;">*</span><b>Price ID:</b> Put in the price id from the Marketplace Price Guide.  If it doesn't have one or isn't tradable, ignore this.</li>
<li><span style="color:red;">*</span><b>Member:</b> Check the box if it's a members item.</li>
<li><span style="color:red;">*</span><b>Tradable:</b> Check the box if the item is tradable.</li>
<li><span style="color:red;">*</span><b>Equipable:</b> Check the box if you can wear the item.</li>
<li><span style="color:red;">*</span><b>Stackable:</b> Check this box if the item stacks in your inventory when you have multiples.</li>
<li><b>Weight:</b> Put in the weight in kilograms or a ? if you don't know it. A guide on finding weights can be found <a href="http://corporate.2007rshelp.com/forums/index.php?showtopic=1648" title="">here</a>.</li>
<li><b>High Alchemy:</b> The amount of gold you get when you high alch the item.</li>
<li><b>Low Alchemy:</b> The amount of gold you get when you low alch the item.</li>
<li><b>Sell to Gen:</b> The amount of gold you get when you sell to the general store.</li>
<li><b>Buy from Gen:</b> The amount of gold it costs to buy from the general store.</li>
<li><span style="color:red;">*</span><b>Quest:</b> Put the exact quest title from <a href="/quests.php" title="">OSRS RuneScape Help</a> if it is used during a quest or can be used/obtained after a quest.  Put in "No" if there is no quest.</li>
<li><span style="color:red;">*</span><b>Examine:</b> Fill in the sentence that appears in your chat box when you examine the item.</li>
<li><span style="color:red;">*</span><b>Complete:</b> Check this box if the item has all fields marked with a <span style="color:red;">*</span> on this list.</li>
<li><span style="color:red;">*</span><b>Obtained from:</b> Who/where you can get the item.  Separate with a semicolon.</li>
<li><span style="color:red;">*</span><b>Attack bonus:</b> Enter in stab|slash|crush|magic|range format, including - for negative numbers but omitting + for positive numbers. (Not necessary for the completion of unequipable quest items)</li>
<li><span style="color:red;">*</span><b>Defence bonus:</b>  Enter in stab|slash|crush|magic|range|summoning format, including - for negative numbers but omitting + for positive numbers. (Not necessary for the completion of unequipable quest items)</li>
<li><span style="color:red;">*</span><b>Other Stat:</b>  Enter in strength|prayer format, including - for negative numbers but omitting + for positive numbers. (Not necessary for the completion of unequipable quest items)</li>
<li><span style="color:red;">*</span><b>Keep or Drop:</b> Whether or not one should keep or drop the item after the quest.</li>
<li><span style="color:red;">*</span><b>Retrieval:</b> How to reobtain the item.</li>
<li><span style="color:red;">*</span><b>Uses:</b> How the item is used in the quest.</li>
<li><span style="color:red;">*</span><b>Notes:</b> Information on the item.  Include as much information as possible.  For example, for a steel platebody, you'd want to give how much experience it gives when you smtih it, how many bars it takes to make, what smithing level is required to make it, as well as the defense level required to wear it.  You may put in a blank line by typing "&lt;br /&gt;&lt;br /&gt;".</li>
<li><span style="color:red;">*</span><b>Keywords:</b> Any sensible keywords that one could need to find the item.  Do not include a word in the title or a part of the word in the title.  If "adamantite" is in the title, "adamant" is not needed for a keyword because the search will already see that "adamant" is part of "adamantite". However, "addy" would be a good keyword to add in.  All keywords should be lowercase and separated with spaces only.  Always write the number of coins like "#gp".</li>
<li><span style="color:red;">*</span><b>Credits:</b> If you contributed or someone without editor access contributed, put his/her/your name here and separate with semicolons.  Only put a name here if the person has contributed the image, the entire top, or the entire bottom of the entry.</li>
</ol>

<a name="2"></a>
<div class="title1">Monster Database</div>
<p>The fields that are a monster entry can be found below with descriptions. A <span style="color:red;">*</span> denotes that the field is necessary in order for any entry to be marked complete. A <span style="color:blue;">*</span> denotes that it's only a necessary field if it's an attackable monster.</p>
<ol>
<li><span style="color:red;">*</span><b>Name:</b> Only the first word is to be capitalized.  Only capitalize succeeding words if they're proper/special names such as Torag the Corrupted.</li>
<li><span style="color:red;">*</span><b>Image:</b> Do not fill this out.  Upload your image and the manager that moves it will fill in this field.</li>
<li><span style="color:red;">*</span><b>Attackable:</b> Check this box if you can attack the monster.  Leave it empty if it's an NPC.</li>
<li><span style="color:blue;">*</span><b>Combat:</b> Combat level.</li>
<li><span style="color:blue;">*</span><b>Hitpoints:</b> Kill a monster recording how many hitpoints it has.  If it takes a long time to kill, subtract 1 hitpoint every 5 seconds.</li>
<li><b>Max hit:</b> The maximum hit a monster can hit.  Most easily found using the Monster Examine Lunar spell.</li>
<li><span style="color:red;">*</span><b>Race:</b> The race of the monster.  Includes but is not limited to Animal, Beast, Demon, Dragon, Dwarf, Giant, Goblin, Human, Bug, Gnome, Elven, Undead, Ent, Human, or Mage.
<li><span style="color:red;">*</span><b>Quest:</b> Put the exact quest title from <a href="/quests.php" title="">OSRS RuneScape Help</a> if the NPC exists because of a quest. Black dragon is not a quest monster just because you have to kill it for RFD. If it's not part of a quest, put "No".</li>
<li><span style="color:blue;">*</span><b>Nature:</b> The only options here are "Aggressive" or "Not Aggressive".  If the monster attacks you without you attacking it first, use the latter.</li>
<li><span style="color:blue;">*</span><b>Attack Style:</b> Say whether or not the monster attacks with Magic, Range, or Melee.  More than one can apply.</li>
<li><span style="color:red;">*</span><b>Examine:</b> The Fill in the sentence that appears in your chat box when you examine the monster.</li>
<li><span style="color:red;">*</span><b>Where Found:</b> The locations of the monster. Separate with semicolons.  If you're saying a specific and general location, separate with a comma.  For example "Chicken pen, Lumbridge".  Include city names so that the monster will appear in city guide.</li>
<li><span style="color:blue;">*</span><b>Drops/Top Drops:</b> Low to medium value drops go in drops.  High value drops and clue scrolls go in top drops. Do not note that certain drops will only be dropped in a members world in the drops area.  Put 100% drops first and try to group drops together (with armour together, ammo together, etc.).  Rememeber that besides a few exception on the chart below, you must fill out drops by their exact item name.  Read the table below to see common mistakens when listing drops in Monster Database entries:
<table cellspacing="0" style="border-left: 1px solid #000000;border-top: 1px solid #000000;" width="95%">
<tr class="tabletop">
<th style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;">Category</th>
<th style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;">Description</th>
<th style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;">Bad Example</th>
<th style="border-right: 1px solid #000000; border-bottom: 1px solid #000000;">Good Example</th></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Abbreviations</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Don't use them. Spell out the full name.</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Rune scimmy</td>
<td class="tablebottom">Rune scimitar</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Ranges</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Separate highest and lowest drop numbers with a "-"</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Coins (22,44,100)</td>
<td class="tablebottom">Coins (22-100)</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Capitalization</td>
<td colspan="3" class="tablebottom">Follow the Name guidelines for Item Database section.</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Noted items</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Precede with noted (lowercase).</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Noted Copper ore (10)</td>
<td class="tablebottom">noted Copper ore (10)</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Metal types</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Spell out the metal. For adamant equipment say adamant (but bars and ores are adamantite).</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Mith battleaxe / Adamantite boots</td>
<td class="tablebottom">Mithril battleaxe / Adamant boots</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Listing</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">List with a comma, then a space.</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Copper ore and Bronze bar or Tin ore</td>
<td class="tablebottom">Copper ore, Bronze bar, Tin ore</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Potions</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Put doses in ().</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Super attack 3-dose</td>
<td class="tablebottom">Super attack (3)</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Clue scrolls</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Use "Clue scroll (level-#)" format.</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Clue scroll (lvl-2) / Clue scroll level 2</td>
<td class="tablebottom">Clue scroll (level-2)</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Helmets</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Use "helm", not "helmet", "full", not "large", and "med", not "medium".</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Rune large helmet</td>
<td class="tablebottom">Rune full hell</td>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Square shields</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Use "sq" and "shield".</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Rune square</td>
<td class="tablebottom">Rune sq shield</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Swords</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Shortswords are called "sword"s. 2 handed swords are called "2h sword"s.
<td style="border-right: 1px solid #000000;" class="tablebottom">Iron shortsword / Iron 2-hander</td>
<td class="tablebottom">Iron sword / Iron 2h sword</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Gems</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Just say "Uncut gems"</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Sapphire, Emerald, Ruby, Diamond</td>
<td class="tablebottom">Uncut gems</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Woodcutting axes</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Use "axe" instead of "hatchet".</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Rune hatchet</td>
<td class="tablebottom">Rune axe</td>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Key halves</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Say "Half of a key" in top drops.</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Loop key half, Teeth key half</td>
<td class="tablebottom">Half of a key</td></tr>

<tr>
<td style="border-right: 1px solid #000000;" class="tablebottom">Dragon shield halves</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Put "Shield left half" in top drops.</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Dragon left shield half</td>
<td class="tablebottom">Shield left half</td></tr>

<tr><td style="border-right: 1px solid #000000;" class="tablebottom">Herbs</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Always say "Grimy herbs".</td>
<td style="border-right: 1px solid #000000;" class="tablebottom">Grimy ranarrs, Grimy kwuarm</td>
<td class="tablebottom">Grimy herbs</td></tr>
</table></li>
<li><b>Tactic:</b> In this field, describe any effective ways for killing the monster such as beneficial weapons or armour.</li>
<li><b>Notes:</b> Note here certain abilities the monster has or other notes such as what level slayer it requires to kill for slayer monsters.  Always write the number of coins like "#gp".</li>
<li><b>Keywords:</b> Any sensible words that one might search for or misspell.  Don't include words in the title or parts of words in the title.  For example, if the monster is "Green dragon", "drag" is not needed as a keyword.</li>
<li><b>Credits:</b> List of names of people who've contributed.  Separate with semicolons.  Only put your name or someone else's name if they've contributed a picture or entered the entire top or entire bottom of the entry.</li>
</ol>
<p>When you've completed a monster entry or notice that one has what it needs to be considered completed, post in the list in the Monster Database notepad, or in the messagebox.</p>

<a name="3"></a>
<div class="title1">Calculators</div>
<p>The calculator manager is pretty straightforward.  Select the skill you want from the drop down.  The list below details how to complete each of the fields of calculator entry.</p>
<ol>
<li><b>Name:</b> Type in the name of the action or item giving experience.</li>
<li><b>Image:</b> This is already preceded with "/img/".  Don't bother putting images of monsters in the combat related calculators.</li>
<li><b>Level:</b> The level required to complete the action/make the item giving experience.</li>
<li><b>Base XP:</b> The amount of experience the item/action gives.  For combat related calculators, multiply the HP of the monster by 4.</li>
<li><b>Type:</b> Select the most relevant type from the drop down.  If no type seems to make sense, request a new one from a manager+.</li>
<li><b>Members:</b> Select yes if the item/action requires a membership and no if it's F2P.</li></ol>


</td></tr><tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>Jeremy</b></td>  
</tr>
</table>
</div>
<?php
end_page();
?>