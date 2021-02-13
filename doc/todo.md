# Known improvement possibilities

- [ ] Rewrite loading of Z-Way JSON values to avoid that `Connection: keep-alive` in the Z-Way API makes the `file_get_contents` waits until timeout
- [ ] Add the timeout (workaround of `Connection: keep-alive` topic) be a part of the config parameters
- [ ] switch to a more modular way for element definition (Element "API"?) for less "entangled" code
- [ ] Allow more then Z-Way and "internal" values like timestamp a data source (more long term as this will require some bigger rework)
- [ ] Rename XML attributes like `fromleft` to a better name while keeping it backwards compatible
- [ ] add a more easy way to develop new elements and debug how they look
- [ ] ...
