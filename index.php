<?php
include 'func.php';
require_once 'vendor/autoload.php';
// Data load
//$config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c82g1biad3ia12591r1g'); // My API key
$config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c83pcuaad3ift3bmeg4g'); // Janek API key
$client = new Finnhub\Api\DefaultApi(
	new GuzzleHttp\Client(),
	$config
);
$symbolsAll = json_decode(file_get_contents('symbols.json'));
?>
<!--<script src="scroll.js"></script> // Wasn't success yet /scroll name line with wheel-->
<link rel="stylesheet" href="style.css" type="text/css"/>
<div class="namesAll">
	<?php foreach ($symbolsAll as $index => $symbolEach) {
		echo "<p>" . $symbolEach->symbol . " </p> ";
	} ?>
</div>
<body>
<form class="form" method="GET">
  <input id="search_field" type="text" name="name"/>
  <input id="search_button" type="submit" name="" value="Go!"/>
</form>
<div class="centerObjects">
	<?php

	if (isset($_GET["name"])) {
		$find = strtoupper($_GET["name"]);
		$quote = $client->quote("$find"); // Request info by symbol
		/** Get only one field */
		?>
    <div class="column2">
      <div class="valName"><?php echo $_GET["name"]; ?><span class="smallCorner"><strong><?php echo $quote['c']; ?></strong></span></div>
	    <?php if ($quote['dp'] < 0) { ?>
        <div class="colorTextRed"><b class="sign">⪗ </b>
          <span class="span14px"><?php echo number_format($quote['dp'], 2, '.', ''); ?>%</span>
          <span class="smallBottom">(<?php echo $quote['o']; ?>>)</span>
        </div>
	    <?php } else { ?>
        <div class="colorTextGreen"><b class="sign">⪀ </b>
          <span class="span14px"> <?php echo number_format($quote['dp'], 2, '.', ''); ?>%</span>
          <span class="smallBottom">(<?php echo $quote['o']; ?>>)</span>
        </div>
	    <?php } ?>
    </div>
    <div class="column2">
      <div class="valName">Change: <span class="smallCorner"><strong><?php echo $quote['d']; ?></strong></span></div>
      <div class="valName">High price of the day: <span
          class="smallCorner"><strong><?php echo $quote['h']; ?></strong></span></div>
      <div class="valName">Low price of the day: <span
          class="smallCorner"><strong><?php echo $quote['i']; ?></strong></span>
      </div>
      <div class="valName">Previous close price: <span
          class="smallCorner"><strong><?php echo $quote['pc']; ?></strong></span>
      </div>
    </div>
		<?php
	} else {
		foreach ($symbolsAll as $i => $symbol) {
			$random[] = $symbolsAll[$i]->symbol;
			shuffle($random);

			$quote = $client->quote("$random[$i]"); // Request info by symbol
			$quote[$i] = $quote
			/** 4 fields with information */
			?>
      <div class="column">
        <div class="valName"><?php echo $random[$i]; ?><span
            class="smallCorner"><strong><?php echo $quote[$i]['c']; ?></strong></span>
        </div>
				<?php if ($quote[$i]['dp'] < 0) { ?>
          <div class="colorTextRed"><b class="sign">⪗ </b>
            <span class="span14px"><?php echo number_format($quote[$i]['dp'], 2, '.', ''); ?>%</span>
            <span class="smallBottom">(<?php echo $quote[$i]['o']; ?>>)</span>
          </div>
				<?php } else { ?>
          <div class="colorTextGreen"><b class="sign">⪀ </b>
            <span class="span14px"><?php echo number_format($quote[$i]['dp'], 2, '.', ''); ?>%</span>
            <span class="smallBottom">(<?php echo $quote[$i]['o']; ?>>)</span>
          </div>
				<?php } ?>
      </div>
			<?php
			if ($i == 7) { // <- Better chance see both colors
				break;
			}
		}
	}
	?>
</div>
</body>















