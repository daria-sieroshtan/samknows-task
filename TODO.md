## TODO
* Process each file in its own thread for concurrency
* Use templating to decouple it from the code
* Provide descriptive error messages
* Add the integration tests for the command as a whole
* Add unit tests for classes that currently lack ones
* Validate the input data, for instance, check that datetime is well-formed time period
* Ban adding duplicate statistic names in App\Entity\Statistic->addStatistic()
* Make 'insights' section easily extendable (similar to the current implementation of the statistics section)
* Tracking unit converters (e.g. creating a state machine that allows several sequential conversions for requested units if direct converter is not available)


