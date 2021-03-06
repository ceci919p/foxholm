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
                <p class="pris"></p>
                <div>
                
            </article>
        </template>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="produkt_wrapper">
            <nav id="filtrering_lowercase">
				<p>Vælg kategori:</p>
				<button class="filter" data-accessori="alle">Alle</button>
			</nav>
            <section id="oversigt"></section>
        </div>
        </main><!-- #main -->
        
        <script>
        console.log("Hip Hurra");
        let accessories;
        let kategorier;
        //variabel der holder styr på hvilken kategori der er blevet valgt.
        let filterAccessori = "alle";
        document.addEventListener("DOMContentLoaded", start);
        function start() {
            getJson();
        }
        const url = "https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/wp-json/wp/v2/accessori";
        const kategoriUrl = "https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/wp-json/wp/v2/filteraccessori";
        async function getJson() {
            
            const data = await fetch(url);
            const kategoridata = await fetch(kategoriUrl);
            accessories = await data.json();
            kategorier = await kategoridata.json();
            console.log(kategorier);
            //kald til funktionen visAccessories
            visAccessories();
            //kald til funktionen opretknapper
            opretknapper();
        }
        function opretknapper () {
            kategorier.forEach(kategori =>{
                //lav en funktion der opretter knapper med kategori id som data attribut
                document.querySelector("#filtrering_lowercase").innerHTML += `<button class="filter" data-accessori="${kategori.name}">${kategori.name}</button>`
                
                addEventListenersToButtons();
            })
        }
        function addEventListenersToButtons(){
            //vælg alle filtreringsknapper og for hvert element skal der tilføjes en EventListener.
            document.querySelectorAll("#filtrering_lowercase button").forEach(elm =>{
                elm.addEventListener("click", filtrering);
            })
        };
        //funktion til filtrering
        function filtrering(){
            //variablen der holder styr på hvilken kategori der er blevet valgt er let filterAccessori.
            //vi definerer at variblen er den der lige er blevet klikket på med "this". 
            //når vi vil have fat i data-attribut bruges dataset og efterfølgende hvad data-attributten hedder 
            filterAccessori = this.dataset.accessori;
            document.querySelectorAll("#filtrering_lowercase .filter").forEach(elm => {

                elm.classList.remove("valgt");

            });
            this.classList.add("valgt");
            console.log("hej " + filterAccessori);
            visAccessories();
        }

        function visAccessories () {
            console.log(accessories);
            
            const liste = document.querySelector("#oversigt");
            const skabelon = document.querySelector("template");
            liste.textContent = "";
            accessories.forEach(accessori => {
                //Hvis arrayet viser tal skal filterAccessori også skal laves om til tal. Dette gøres med parseInt() - så det ville hedde (parseInt(filterAccessori)). I mit tilfælde havde jeg tekst og derfor skulle filterAccessori forblive tekst.
                console.log(accessori.kategori);
                if (filterAccessori == "alle" || accessori.kategori.includes(filterAccessori)){
                const klon = skabelon.cloneNode(true).content;
                klon.querySelector("img").src = accessori.billede.guid;
                klon.querySelector(".titel").textContent = accessori.title.rendered;
                klon.querySelector(".maerke").textContent = "Mærke: " + accessori.maerke;
                klon.querySelector(".pris").innerHTML = "Pris: " + accessori.pris + " kr";
                klon.querySelector("article").addEventListener("click", () => {
                    location.href = accessori.link; })
                liste.appendChild(klon);
                }
            })
        }
        </script>
        
    </div><!-- #primary -->

<?php get_footer(); ?>
