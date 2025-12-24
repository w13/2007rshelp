<?php
	if(IN_ZYBEZ !== true) exit;
?>
<style type="text/css">
#skills, #xp {
margin: 0 auto;
width: 540px;
border-collapse: collapse;
}
#skills strong {
display: block;
text-align: center;
}
#skills a {
display: block;
text-decoration: none;
}
#skills td {
vertical-align: top;
width: 180px;
}
#skills img {
vertical-align: middle;
padding-right: 5px;
}
#xp td, #xp th {
border: 1px solid #000;
text-align: center;
}
</style>
<script type="text/javascript">
function changeUser() {
	var usr = prompt("Please enter a character to grab levels from:");
	if(usr) {
		if(window.location.href.indexOf('?') == -1)
			window.location.href += '?user='+usr;
		else
			window.location.href += '&user='+usr;
	}
}
</script>
<div class="boxtop">Runescape Skill Calculators</div><div class="boxbottom" style="padding: 6px 24px">

<div style="margin: 1pt; font-size: large; font-weight: bold;">
	» Runescape Calculators
</div>
<hr class="main" noshade="noshade" />

<table id="skills">
<tr><td>
<a href="?calc=Attack" title="Runescape Attack Calculator"><img src="/img/calcimg/Attack.gif" />Attack</a>
<a href="?calc=Strength" title="Runescape Strength Calculator"><img src="/img/calcimg/Strength.gif" />Strength</a>
<a href="?calc=Defence" title="Runescape Defence Calculator"><img src="/img/calcimg/Defence.gif" />Defence</a>
<a href="?calc=Ranged" title="Runescape Ranged Calculator"><img src="/img/calcimg/Ranged.gif" />Ranged</a>
<a href="?calc=Prayer" title="Runescape Prayer Calculator"><img src="/img/calcimg/Prayer.gif" />Prayer</a>
<a href="?calc=Magic" title="Runescape Magic Calculator"><img src="/img/calcimg/Magic.gif" />Magic</a>
<a href="?calc=Runecrafting" title="Runescape Runecrafting Calculator"><img src="/img/calcimg/Runecrafting.gif" />Runecrafting</a>
<a href="?calc=Construction" title="Runescape Construction Calculator"><img src="/img/calcimg/Construction.gif" />Construction</a>
</td><td>
<a href="?calc=Combat" title="Runescape Combat Calculator"><img src="/img/calcimg/Combat_sm.gif" />Combat</a>
<a href="?calc=Hitpoints" title="Runescape Hitpoints Calculator"><img src="/img/calcimg/Hitpoints.gif" />Hitpoints</a>
<a href="?calc=Agility" title="Runescape Agility Calculator"><img src="/img/calcimg/Agility.gif" />Agility</a>
<a href="?calc=Herblore" title="Runescape Herblore Calculator"><img src="/img/calcimg/Herblore.gif" />Herblore</a>
<a href="?calc=Thieving" title="Runescape Thieving Calculator"><img src="/img/calcimg/Thieving.gif" />Thieving</a>
<a href="?calc=Crafting" title="Runescape Crafting Calculator"><img src="/img/calcimg/Crafting.gif" />Crafting</a>
<a href="?calc=Fletching" title="Runescape Fletching Calculator"><img src="/img/calcimg/Fletching.gif" />Fletching</a>
<a href="?calc=Slayer" title="Runescape Slayer Calculator"><img src="/img/calcimg/Slayer.gif" />Slayer</a>
</td><td>
<a href="?calc=Mining" title="Runescape Mining Calculator"><img src="/img/calcimg/Mining.gif" />Mining</a>
<a href="?calc=Smithing" title="Runescape Smithing Calculator"><img src="/img/calcimg/Smithing.gif" />Smithing</a>
<a href="?calc=Fishing" title="Runescape Fishing Calculator"><img src="/img/calcimg/Fishing.gif" />Fishing</a>
<a href="?calc=Cooking" title="Runescape Cooking Calculator"><img src="/img/calcimg/Cooking.gif" />Cooking</a>
<a href="?calc=Firemaking" title="Runescape Firemaking Calculator"><img src="/img/calcimg/Firemaking.gif" />Firemaking</a>
<a href="?calc=Woodcutting" title="Runescape Woodcutting Calculator"><img src="/img/calcimg/Woodcutting.gif" />Woodcutting</a>
<a href="?calc=Farming" title="Runescape Farming Calculator"><img src="/img/calcimg/Farming.gif" />Farming</a>
<a href="?calc=Hunter" title="Runescape Hunter Calculator"><img src="/img/calcimg/hunter.gif" />Hunter</a>
</td></tr></table>

<div style="margin: 1pt; font-size: large; font-weight: bold;">
	» Experience Table
</div>
<hr class="main" noshade="noshade" />

<table id="xp" cellspacing="0">
<tr><th class="tabletop" width="36">Level</th><th class="tabletop">Experience</th><th class="tabletop" width="36">Level</th><th class="tabletop">Experience</th><th class="tabletop" width="36">Level</th><th class="tabletop">Experience</th><th class="tabletop" width="36">Level</th><th class="tabletop">Experience</th></tr>
<tr><td>1</td><td>0</td><td>26</td><td>8,740</td><td>51</td><td>111,945</td><td>76</td><td>1,336,443</td></tr>
<tr><td>2</td><td>83</td><td>27</td><td>9,730</td><td>52</td><td>123,660</td><td>77</td><td>1,475,581</td></tr>
<tr><td>3</td><td>174</td><td>28</td><td>10,824</td><td>53</td><td>136,594</td><td>78</td><td>1,629,200</td></tr>
<tr><td>4</td><td>276</td><td>29</td><td>12,031</td><td>54</td><td>150,872</td><td>79</td><td>1,798,808</td></tr>
<tr><td>5</td><td>388</td><td>30</td><td>13,363</td><td>55</td><td>166,636</td><td>80</td><td>1,968,068</td></tr>
<tr><td>6</td><td>512</td><td>31</td><td>14,833</td><td>56</td><td>184,040</td><td>81</td><td>2,192,818</td></tr>
<tr><td>7</td><td>650</td><td>32</td><td>16,456</td><td>57</td><td>203,254</td><td>82</td><td>2,421,087</td></tr>
<tr><td>8</td><td>801</td><td>33</td><td>18,247</td><td>58</td><td>224,466</td><td>83</td><td>2,673,114</td></tr>
<tr><td>9</td><td>969</td><td>34</td><td>20,224</td><td>59</td><td>247,886</td><td>84</td><td>2,951,373</td></tr>
<tr><td>10</td><td>1,154</td><td>35</td><td>22,406</td><td>60</td><td>273,742</td><td>85</td><td>3,258,594</td></tr>
<tr><td>11</td><td>1,358</td><td>36</td><td>24,815</td><td>61</td><td>302,288</td><td>86</td><td>3,597,729</td></tr>
<tr><td>12</td><td>1,584</td><td>37</td><td>27,473</td><td>62</td><td>333,804</td><td>87</td><td>3,972,294</td></tr>
<tr><td>13</td><td>1,833</td><td>38</td><td>30,408</td><td>63</td><td>368,599</td><td>88</td><td>4,385,776</td></tr>
<tr><td>14</td><td>2,107</td><td>39</td><td>33,648</td><td>64</td><td>407,015</td><td>89</td><td>4,842,295</td></tr>
<tr><td>15</td><td>2,411</td><td>40</td><td>37,224</td><td>65</td><td>449,428</td><td>90</td><td>5,346,332</td></tr>
<tr><td>16</td><td>2,746</td><td>41</td><td>41,171</td><td>66</td><td>496,254</td><td>91</td><td>5,902,831</td></tr>
<tr><td>17</td><td>3,115</td><td>42</td><td>45,529</td><td>67</td><td>547,953</td><td>92</td><td>6,517,253</td></tr>
<tr><td>18</td><td>3,523</td><td>43</td><td>50,339</td><td>68</td><td>605,032</td><td>93</td><td>7,195,629</td></tr>
<tr><td>19</td><td>3,973</td><td>44</td><td>55,649</td><td>69</td><td>668,051</td><td>94</td><td>7,994,614</td></tr>
<tr><td>20</td><td>4,470</td><td>45</td><td>61,512</td><td>70</td><td>737,627</td><td>95</td><td>8,771,558</td></tr>
<tr><td>21</td><td>5,018</td><td>46</td><td>67,983</td><td>71</td><td>814,445</td><td>96</td><td>9,684,577</td></tr>
<tr><td>22</td><td>5,624</td><td>47</td><td>75,127</td><td>72</td><td>899,256</td><td>97</td><td>10,692,629</td></tr>
<tr><td>23</td><td>6,291</td><td>48</td><td>83,014</td><td>73</td><td>992,895</td><td>98</td><td>11,805,606</td></tr>
<tr><td>24</td><td>7,028</td><td>49</td><td>91,721</td><td>74</td><td>1,096,278</td><td>99</td><td>13,034,431</td></tr>
<tr><td>25</td><td>7,842</td><td>50</td><td>101,333</td><td>75</td><td>1,210,421</td><td colspan="2">&nbsp;</td></tr>
</table>

</div>
<?php
end_page();
