# RRuleUnravel PHP Composer Library

Takes an iCal/ics RRULE (and associated data) and returns you all the occurrences of that Rule.

## Version & State

It is marked pre version 1 as it does not deal will all parts of the iCal/ics RRULE spec yet, only some parts. It will not be marked v1.0 until it deals will all the commonly used parts. 

## Use

### Set up Data

The ICalData object should be set up with all needed info. This includes the timezone, start and end and RRULE. 

    $icalData = new ICalData(
	    new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
	    new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
	    "FREQ=MONTHLY;BYMONTHDAY=19",
		new \DateTimeZone("Europe/London"));

You can also pass EXDATE lines here.

	$icaldata->addExDateByString("20150226T090000","TZID=Europe/London");

### Set up worker class

    $unraveler = new Unraveler($icalData);

###	Set up options (Optional)

    $unraveler->setIncludeOriginalEvent(false);
	$unraveler->setResultsCountLimit(1);

The ResultFilterAfterDateTime and ResultFilterBeforeDateTime allow you to control which events you get back.

	$unraveler->addResultFilter(new ResultFilterAfterDateTime(new \DateTime('2016-01-01 00:00:00', new \DateTimeZone("Europe/London"))));

###	Process and get results

    $unraveler->process();
    $results = $unraveler->getResults();

The results are an array of UnravelerResult classes, which has methods to get the start and the end.

   *  getStart()
   *  getEnd()

## More

See http://ican.openacalendar.org/ for more.
