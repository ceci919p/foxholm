<?php
/**
 * The template for displaying all pages.
 *
 * @package Neve
 * @since   1.0.0
 */
$container_class = apply_filters( 'neve_container_class_filter', 'container', 'single-page' );

get_header();

?>
<div class="<?php echo esc_attr( $container_class ); ?> single-page-container">
	<div class="row">
		<?php do_action( 'neve_do_sidebar', 'single-page', 'left' ); ?>
		<div class="nv-single-page-wrap col">
			<?php
			/**
			 * Executes actions before the page header.
			 *
			 * @since 2.4.0
			 */
			do_action( 'neve_before_page_header' );

			/**
			 * Executes the rendering function for the page header.
			 *
			 * @param string $context The displaying location context.
			 *
			 * @since 1.0.7
			 */
			do_action( 'neve_page_header', 'single-page' );

			/**
			 * Executes actions before the page content.
			 *
			 * @param string $context The displaying location context.
			 *
			 * @since 1.0.7
			 */
			do_action( 'neve_before_content', 'single-page' );

			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', 'page' );
				}
			} else {
				get_template_part( 'template-parts/content', 'none' );
			}

			/**
			 * Executes actions after the page content.
			 *
			 * @param string $context The displaying location context.
			 *
			 * @since 1.0.7
			 */
			do_action( 'neve_after_content', 'single-page' );
			?>
		</div>
		<?php do_action( 'neve_do_sidebar', 'single-page', 'right' ); ?>
	</div>
</div>
<template>
            <article>
                
                <img src="" alt="">
                <h5 class="titel"></h5>
                <div class="article_text">
                <p class="maerke"></p>
                <p class="stoerrelse"></p>
                <p class="pris"></p>
                <div>
                
            </article>
        </template>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="produkt_wrapper">
            <nav id="filtrering">
				<p>Vælg størrelse:</p>
				<button data-baumtroeje="alle">Alle</button>
			</nav>
            <section id="oversigt"></section>
        </div>
        </main><!-- #main -->
        
        <script>
        console.log("Hip Hurra");
        let baumtroejer;
        let kategorier;
        //variabel der holder styr på hvilken kategori der er blevet valgt.
        let filterBaumtroeje ="alle";
        document.addEventListener("DOMContentLoaded", start);
        function start() {
            getJson();
        }
        const url = "https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/wp-json/wp/v2/baumtroeje/";
        const kategoriUrl = "https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/wp-json/wp/v2/shoppingkategorier/";
        async function getJson() {
            
            const data = await fetch(url);
            const kategoridata = await fetch(kategoriUrl);
            baumtroejer = await data.json();
            kategorier = await kategoridata.json();
            console.log(kategorier);
            //kald til funktionen visBaumtroejer
            visBaumtroejer();
            //kald til funktionen opretknapper
            opretknapper();
        }
        function opretknapper () {
            kategorier.forEach(kategori =>{
                //lav en funktion der opretter knapper med kategori id som data attribut
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-baumtroeje="${kategori.name}">${kategori.name}</button>`
                
                addEventListenersToButtons();
            })
        }
        function addEventListenersToButtons(){
            //vælg alle filtreringsknapper og for hvert element skal der tilføjes en EventListener.
            document.querySelectorAll("#filtrering button").forEach(elm =>{
                elm.addEventListener("click", filtrering);
            })
        };
        //funktion til filtrering
        function filtrering(){
            //variablen der holder styr på hvilken kategori der er blevet valgt er let filterBaumtroeje.
            //vi definerer at variblen er den der lige er blevet klikket på med "this". 
            //når vi vil have fat i data-attribut bruges dataset og efterfølgende hvad data-attributten hedder 
            filterBaumtroeje = this.dataset.baumtroeje;
            console.log(filterBaumtroeje);
            visBaumtroejer();
        }

        function visBaumtroejer () {
            console.log(baumtroejer);
            
            const liste = document.querySelector("#oversigt");
            const skabelon = document.querySelector("template");
            liste.textContent = "";
            baumtroejer.forEach(baumtroeje => {
                //Hvis arrayet viser tal skal filterBaumtroeje også skal laves om til tal. Dette gøres med parseInt() - så det ville hedde (parseInt(filterBaumtroeje)). I mit tilfælde havde jeg tekst og derfor skulle filterBuks forblive tekst.
                console.log(baumtroeje.kategori);
                if (filterBaumtroeje == "alle" || baumtroeje.kategori.includes(filterBaumtroeje)){
                const klon = skabelon.cloneNode(true).content;
                klon.querySelector("img").src = baumtroeje.billede.guid;
                klon.querySelector(".titel").textContent = baumtroeje.title.rendered;
                klon.querySelector(".stoerrelse").textContent = "Størrelse: " + baumtroeje.stoerrelse;
                klon.querySelector(".pris").innerHTML = "Pris: " + baumtroeje.pris + " kr";
                klon.querySelector("article").addEventListener("click", () => {
                    location.href = baumtroeje.link; })
                liste.appendChild(klon);
                }
            })
        }
        </script>
        
    </div><!-- #primary -->

<?php get_footer(); ?>
