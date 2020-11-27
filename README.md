## SamKnows Metric Analyser

This application generates the expected output files (in the `public/outputs` folder) given the input files (in the `public/inputs` folder).

### Running application

Prerequisites:
- `composer`
- `make`
  
Go to the root directory of the project and run  

```bash
    composer install
```
Put input files for processing into `public/inputs` folder and run 

```bash
    make run
```
Generated output files will be saved to `public/outputs`folder.

### Notes
* It is assumed that many more report types will be added, and adding new report types should be easy & decoupled.
* It is assumed that many more metrics, statistics, insights, units of measure can be used in these reports, and adding new should be decoupled.
* Application is run via the command line. It is likely that a web interface / API will be required, so the implementation is decoupled from the entry point.
* It is assumed that the user is not interested in dev details, including possible debugging. So there is currently no sophisticated error handling, no output of the stack traces, logging, etc. This could be adjusted based on the target audience of the app.
* Logic for detecting periods of under-performance was not specified and so implemented as a best effort. It may change based on business input and edge cases discovered.
* It is assumed that the presence of the output file with the same name as the input file means there is no need to generate the new one. There are other valid options and the final decision depends on the workflow that includes this tool.
* input/output folders are currently non-configurable, but it is possible to add those as arguments of the command later. Before providing users with the ability to change this parameter we should consider possible issues given the deployment environment, access rights, etc.
* Memory footprint and running time are considered to be no-issues. If the app is intended to run on a much bigger dataset (>10000 items) very often (> once per minute), additional tricks for partial loading, parallelisation, memory layout, etc. would be required.


