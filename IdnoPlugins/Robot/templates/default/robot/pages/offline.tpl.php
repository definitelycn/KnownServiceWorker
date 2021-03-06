<!-- à la adactio.com/offline -->
<div class="container result-404">
    <div class="row" style="margin-bottom: 2em; margin-top: 6em">
        <div class="col-md-offset-1 col-md-5">
            <h1 class="p-name" style="margin-bottom: 2em;">
                Offline.
            </h1>
            <p>Whatever you were looking for, it's not here at the moment. It might have been moved, deleted, or it doesn't exist. Or the robots ate it. That's always a possibility too.</p>
            <p>Maybe you'll find something interesting if you head back to the <a href="<?=\Idno\Core\Idno::site()->config()->getDisplayURL()?>"><?=\Idno\Core\Idno::site()->config()->title?> homepage</a>.
            </p>
            <div id="history">
            </div>
        </div>
        <div class="col-md-5">
	        <img src="<?=\Idno\Core\Idno::site()->config()->getDisplayURL()?>gfx/robots/aleph_404.png" alt="Robot with a missing sign">
        </div>
    </div>
</div>

<script>
const browsingHistory = [];
caches.open('pages')
.then( cache => {
    cache.keys()
    .then(keys => {
        keys.forEach( request => {
            let data = JSON.parse(localStorage.getItem(request.url));
            if (data) {
                data['url'] = request.url;
                browsingHistory.push(data);
            }
        });
        browsingHistory.sort( (a,b) => {
            return b.timestamp - a.timestamp;
        });
        let markup = '';
        if(browsingHistory.length>0)
            markup += '<p>Other things to look at:</p><dl>';
        browsingHistory.forEach( data => {
          if(data.url.indexOf('offline') == -1)
            markup += `
<dt><a href="${ data.url }">${ data.title }</a></dt>
<dd><p>${ data.description }&hellip;</p><!-- </dd> -->
<p class="meta"><time class="dt-published" datetime="${ data.datetime }">${ data.published }</time></p></dd>
`;
        });
        if(browsingHistory.length>0)
            markup += '</dl>';
        let container = document.getElementById('history');
        container.insertAdjacentHTML('beforeend', markup);
    })
});

// A little embellishment, check for on/off–line-ness of client
  window.addEventListener('load', function() {

  // navigator.onLine

    if(navigator.onLine) {
      // it’s not you it’s the squirrel at this end
      console.log('Squirrel!');
    }

    window.addEventListener('offline', function() {
      // navigator.onLine : false
      // it’s you, though it might be the internet at large
      console.log('You’re offline.');
    });

    window.addEventListener('online', function() {
      // navigator.onLine : true
      console.log('Connection restored!');
    });

  });

</script>
