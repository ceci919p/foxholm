<?php
/**
 * Author:          Andrei Baicus <andrei@themeisle.com>
 * Created on:      28/08/2018
 *
 * @package Neve
 */

$container_class = apply_filters( 'neve_container_class_filter', 'container', 'single-post' );

get_header();
?>
	
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<article>
				<button class="luk">Tilbage</button>
				<section class="single_container">
				<img class="pic" src="" alt="">

				<div class="single_text">
					<h2></h2>
						<p class="pris"></p>
						<p class="maerke"></p>
						<p class="stoerrelse"></p>
						<p class="materiale"></p>
					
						<button>køb</button>
			
			    </div>
			    </section>
			</article>

		</main><!-- #main -->
		
		<script>
			let buks;

			const url = "https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/wp-json/wp/v2/buks/"+<?php echo get_the_ID() ?>;

			async function getJson() {
			const data = await fetch(url);
			buks = await data.json();
			visBuks();
		}

		//vis data om buksen
		function visBuks () {
			document.querySelector("h2").textContent = buks.title.rendered;
			document.querySelector(".pic").src = buks.billede.guid;
			document.querySelector(".pris").innerHTML = buks.pris + " kr";
			document.querySelector(".maerke").textContent = buks.maerke;
			document.querySelector(".stoerrelse").textContent = buks.stoerrelse;
			document.querySelector(".materiale").textContent = buks.materiale;
		}

		document.querySelector(".luk").addEventListener("click", () => {
			//link tilbage til den foregående side på "luk" knappen.
			history.back();
		})

		getJson ();

		</script>
	
	</div><!-- #primary -->

<?php
get_footer();
