### Alani util pack for Laravel

Created and distributed for free by [Bibakis](https://bibakis.com/) under the MIT License.  

---

#### Asset loading helper

Force the browser to always fetch the latest css/js while still caching files if there are no changes. You may have heard this as "cache busting".

Place your css & js files in the /public directory and then simply do the following from any blade file:  
@@asset('web/css/styles.css')  
@@asset('web/js/basic.js')

This will load the files with the appropriate html tag and auto append a version identifier based on the time the file was last updated. For example:  
https://example.com/web/css/styles.css**?v=1755474797**
