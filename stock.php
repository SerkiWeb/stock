<?php

const YEAR =  365;
const START_DATE = '2000-01-01';
const END_DATE = '2019-12-31';
const MAX_PRICE = 150;

class Equity {
	private $name;
	private $value;
	private $history;

	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
		$this->history = [];
	}

	public function sethistory($history)
	{
		$this->history = $history;
		return $this;
	}

	public function gethistory()
	{
		return $this->history;
	}

}

class CotationDay { 
	private $dailyClose;
	private $date;

	public function __construct($dailyClose, $date) {
		$this->dailyClose = $dailyClose;
		$this->date = $date;
	}

	/**
	 * get dailyClose 
	 * @return  int  daily dailyClose
	 *
	 */
	public function getDailyClose()
	{
		return $this->dailyClose;
	}

	/**
	 * get date 
	 * @return DateTime
	 *
	 */	
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * set date 
	 * @param  DateTime  date
	 * @return this
	 *
	 */
	public function setDate($date)
	{
		$this->date = $date;
		return $this;
	}
}

class Model {

	/**
	 * create history, return false if history already exists 
	 * @param  equity Equity  equity 
	 * @param  from string  DateTime format from
	 * @param  to string  DateTime format from    
	 * @return Equity|false 
	 */
	public static function createHistory($equity, $from=START_DATE, $to=END_DATE)
	{

		if (!is_null($equity->gethistory())) {
			return false;
		}

		$equity   = new Equity('equity', 45);
		$interval = new DateInterval('P1D');
		$from    = new DateTime($from);
		$to 	  = new DateTime($to);
		$history  = [];

		echo 'generate values for equities' . PHP_EOL;
		echo 'between  ' . $from . " and " . $to .  PHP_EOL;
		echo  ' max price : '  . MAX_PRICE . PHP_EOL;

		for ($date=$from; $date<$to; $date=$date->add($interval)) {
			$value = rand(0, MAX_PRICE);
			$cotationDay = new CotationDay($value, $date);
			$history[] = $cotationDay;
		}

		$equity->sethistory($history);

		return $equity;
	}
}
$history = '[';
foreach ($equity->gethistory() as $key => $cotation) {

	$history .= '{ x : ' . $cotation->getDate()->format('Ymd')  . ', y : ' . $cotation->getDailyClose() . '}'; 
	$history .= ',';
}
$history .= ']';
?>


<canvas id="myChart" width="400" height="400"></canvas>
 <script  type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
<script "text/javascript">
var history = <?php echo json_encode($history); ?>;
var ctx = document.getElementById('myChart').getContext('2d');
console.log(history);
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: history,
});
</script>