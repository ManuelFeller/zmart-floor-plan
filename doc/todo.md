# Known improvement possibilities

- [ ] Rewrite loading of Z-Way JSON values to avoid that `Connection: keep-alive` in the Z-Way API makes the `file_get_contents` waits until timeout
- [ ] switch to a more modular way for element definition (Element "API"?) for less "entangled" code
- [ ] Allow more then Z-Way and "internal" values like timestamp a data source (more long term as this will require some bigger rework)
- [ ] ...