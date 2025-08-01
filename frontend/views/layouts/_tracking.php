<?php if (Yii::$app->params['enableAnalytics']): ?>

	<?php if (Yii::$app->params['frontendType'] == 'visitor'): ?>
		<!-- Matomo -->
		<script type="text/javascript">
		  var _paq = window._paq = window._paq || [];
		  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
		  _paq.push(['trackPageView']);
		  _paq.push(['enableLinkTracking']);
		  (function() {
			var u="//stats.ourheritage.ch/";
			_paq.push(['setTrackerUrl', u+'matomo.php']);
			_paq.push(['setSiteId', '1']);
			var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
			g.type='text/javascript'; g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
		  })();
		</script>
		<!-- End Matomo Code -->
		
		<!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11171923062"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-11171923062'); </script>
	
		<?php if (Yii::$app->params['isConversionPage']): ?>
			<!-- Event snippet for Website traffic conversion page --> <script> gtag('event', 'conversion', {'send_to': 'AW-11171923062/Lcq2CPTQ3aAYEPaImM8p'}); </script>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if (Yii::$app->params['frontendType'] == 'edu'): ?>
		<!-- Matomo -->
		<script>
		  var _paq = window._paq = window._paq || [];
		  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
		  _paq.push(['trackPageView']);
		  _paq.push(['enableLinkTracking']);
		  (function() {
			var u="https://stats.ourheritage.ch/";
			_paq.push(['setTrackerUrl', u+'matomo.php']);
			_paq.push(['setSiteId', '2']);
			var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
			g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
		  })();
		</script>
		<!-- End Matomo Code -->
	<?php endif; ?>

	<?php if (isset($_GET["trackType"]) && isset($_GET["trackName"]) && isset($_GET["trackValue"])): ?>
		<script>
			_paq.push(['trackEvent', 'Code', '<?= $_GET["trackType"] ?>', '<?= $_GET["trackName"] ?>', '<?= $_GET["trackValue"] ?>']);
		</script>
	<?php endif; ?>
	
<?php endif; ?>
