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
                <h3 class="titel"></h3>
                <p class="maerke"></p>
                <p class="stoerrelse"></p>
                <p class="pris"></p>
                
            </article>
        </template>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <nav id="filtrering"><button data-buks="alle">Alle</button>
			<h3>Filtrer efter størrelse:</h3>
			</nav>

            <section id="oversigt"></section>
        </main><!-- #main -->
        
        <script>
        console.log("Hip Hurra");
        let bukser;
        let stoerrelser;
        //variabel der holder styr på hvilken kategori der er blevet valgt.
        let filterBuks ="alle";
        document.addEventListener("DOMContentLoaded", start);
        function start() {
            getJson();
        }
        const url = "https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/wp-json/wp/v2/buks";
        const stoerrelseUrl = "https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/wp-json/wp/v2/filterstoerrelse";
        async function getJson() {
            
            const data = await fetch(url);
            const stoerrelsedata = await fetch(stoerrelseUrl);
            bukser = await data.json();
            stoerrelser = await stoerrelsedata.json();
            console.log(stoerrelser);
            //kald til funktionen visBukser
            visBukser();
            //kald til funktionen opretknapper
            opretknapper();
        }
        function opretknapper () {
            stoerrelser.forEach(stoerrelse =>{
                //lav en funktion der opretter knapper med kategori id som data attribut
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-buks="${stoerrelse.name}">${stoerrelse.name}</button>`
                
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
            //variablen der holder styr på hvilken kategori der er blevet valgt er let filterBuks.
            //vi definerer at variblen er den der lige er blevet klikket på med "this". 
            //når vi vil have fat i data-attribut bruges dataset og efterfølgende hvad data-attributten hedder 
            filterBuks = this.dataset.buks;
            console.log(filterBuks);
            visBukser();
        }

        function visBukser () {
            console.log(bukser);
            
            const liste = document.querySelector("#oversigt");
            const skabelon = document.querySelector("template");
            liste.textContent = "";
            bukser.forEach(buks => {
                //Hvis arrayet viser tal skal filterBuks også skal laves om til tal. Dette gøres med parseInt() - så det ville hedde (parseInt(filterBuks)). I mit tilfælde havde jeg tekst og derfor skulle filterBuks forblive tekst.
                console.log(buks.stoerrelse);
                if (filterBuks == "alle" || buks.stoerrelse.includes(filterBuks)){
                const klon = skabelon.cloneNode(true).content;
                klon.querySelector("img").src = buks.billede.guid;
                klon.querySelector(".titel").textContent = buks.title.rendered;
                klon.querySelector(".maerke").textContent = "Mærke: " + buks.maerke;
                klon.querySelector(".stoerrelse").textContent = "Størrelse: " + buks.stoerrelse;
                klon.querySelector(".pris").innerHTML = "Pris: " + buks.pris + " kr";
                klon.querySelector("article").addEventListener("click", () => {
                    location.href = buks.link; })
                liste.appendChild(klon);
                }
            })
        }
        </script>
        
    </div><!-- #primary -->

<?php get_footer(); ?>
