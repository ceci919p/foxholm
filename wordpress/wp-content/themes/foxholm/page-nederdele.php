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
				<button data-nederdel="alle">Alle</button>
			</nav>
            <section id="oversigt"></section>
        </div>
        </main><!-- #main -->
        
        <script>
        console.log("Hip Hurra");
        let nederdele;
        let stoerrelser;
        //variabel der holder styr på hvilken kategori der er blevet valgt.
        let filterNederdel ="alle";
        document.addEventListener("DOMContentLoaded", start);
        function start() {
            getJson();
        }
        const url = "https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/wp-json/wp/v2/nederdel";
        const stoerrelseUrl = "https://ceciliejasmin.dk/kea/10_eksamensprojekt/foxholm/wordpress/wp-json/wp/v2/filterstoerrelse";
        async function getJson() {
            
            const data = await fetch(url);
            const stoerrelsedata = await fetch(stoerrelseUrl);
            nederdele = await data.json();
            stoerrelser = await stoerrelsedata.json();
            console.log(stoerrelser);
            //kald til funktionen visNederdele
            visNederdele();
            //kald til funktionen opretknapper
            opretknapper();
        }
        function opretknapper () {
            stoerrelser.forEach(stoerrelse =>{
                //lav en funktion der opretter knapper med kategori id som data attribut
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-nederdel="${stoerrelse.name}">${stoerrelse.name}</button>`
                
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
            //variablen der holder styr på hvilken kategori der er blevet valgt er let filterNederdel.
            //vi definerer at variblen er den der lige er blevet klikket på med "this". 
            //når vi vil have fat i data-attribut bruges dataset og efterfølgende hvad data-attributten hedder 
            filterNederdel = this.dataset.nederdel;
            console.log(filterNederdel);
            visNederdele();
        }

        function visNederdele () {
            console.log(nederdele);
            
            const liste = document.querySelector("#oversigt");
            const skabelon = document.querySelector("template");
            liste.textContent = "";
            nederdele.forEach(nederdel => {
                //Hvis arrayet viser tal skal filterNederdel også skal laves om til tal. Dette gøres med parseInt() - så det ville hedde (parseInt(filterNederdel)). I mit tilfælde havde jeg tekst og derfor skulle filterNederdel forblive tekst.
                console.log(nederdel.stoerrelse);
                if (filterNederdel == "alle" || nederdel.stoerrelse.includes(filterNederdel)){
                const klon = skabelon.cloneNode(true).content;
                klon.querySelector("img").src = nederdel.billede.guid;
                klon.querySelector(".titel").textContent = nederdel.title.rendered;
                klon.querySelector(".maerke").textContent = "Mærke: " + nederdel.maerke;
                klon.querySelector(".stoerrelse").textContent = "Størrelse: " + nederdel.stoerrelse;
                klon.querySelector(".pris").innerHTML = "Pris: " + nederdel.pris + " kr";
                klon.querySelector("article").addEventListener("click", () => {
                    location.href = nederdel.link; })
                liste.appendChild(klon);
                }
            })
        }
        </script>
        
    </div><!-- #primary -->

<?php get_footer(); ?>
