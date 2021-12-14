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

		<div class="nv-page-title ">
		<small class="nv--yoast-breadcrumb neve-breadcrumbs-wrapper">
			<span>
				<span>
					<a href="https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/">Home</a> » 
					<a href="https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/overtoejflertal/">Overtøj</a> »
					<span class="breadcrumb_last" aria-current="page">Detaljer</span>
				</span>
			</span>
		</small>
		
		
					</div>

			<article>
				<button class="luk">Tilbage</button>
				<section class="single_container">
				<img class="pic" src="" alt="">

				<div class="single_text">
					<div class="text_wrapper">
						<h2></h2>
						<p class="pris"></p>
						<p class="maerke"></p>
						<p class="stoerrelse"></p>
						<p class="materiale"></p>
						
						<div class="button_wrapper">
						<button>KØB</button>
					    </div>
					</div>
				</div>
			    </section>
			</article>

		</main><!-- #main -->
		
		<script>
			let overtoej;

			const url = "https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/wp-json/wp/v2/overtoej/"+<?php echo get_the_ID() ?>;

			async function getJson() {
			const data = await fetch(url);
			overtoej = await data.json();
			visOvertoej();
		}

		//vis data om overtøj
		function visOvertoej () {
			document.querySelector("h2").textContent = overtoej.title.rendered;
			document.querySelector(".pic").src = overtoej.billede.guid;
			document.querySelector(".pris").innerHTML = "Pris:  " + overtoej.pris + " kr";
			document.querySelector(".maerke").innerHTML = "Mærke:  " + overtoej.maerke;
			document.querySelector(".stoerrelse").innerHTML = "Størrelse:  " + overtoej.stoerrelse;
			document.querySelector(".materiale").innerHTML = "Materiale:  " + overtoej.materiale;
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
