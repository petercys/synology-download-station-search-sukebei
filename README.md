# synology-download-station-search-nyaasi

BT Search package used by Synology Download Station to search through 
[nyaa.si](https://nyaa.si/).

## Build

```console
$ make nyaa.dlm
```

## Notes

Currently the search function use the RSS endpoint of Nyaa.si, this endpoint 
only returns the first 75 results for a query. There's also no way to specify
which category to use with this search package. It might be interesting to
build different packages depending on the category of content to return or use
another method to retrieve all the entries for a query on Nyaa.si to have more 
than 75 results.
