<?php
/*
Plugin Name: GDPR Cookie Notice & Compliance
Plugin URI: https://www.eteam.dk/om-eteam/
Description: Simple utility plugin for GDPR compliance
Version: 1.0.0
Author: Eteam.dk
Author URI: https://www.eteam.dk/
Copyright: Eteam.dk
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: gdprcono
Domain Path: /lang
*/

/*
    Copyright Eteam.dk

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1335, USA
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

if( ! class_exists( 'gdpr_cookie_notice_compliance' ) ) :

class gdpr_cookie_notice_compliance {

	/*
	*  __construct
	*
	*  A dummy constructor to ensure GDPR Cookie Notice & Compliance is only initialized once
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	public function __construct() {
		// Do nothing here.
	}

	/*
	*  initialize
	*
	*  The real constructor to initialize GDPR Cookie Notice & Compliance
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	public function initialize() {
		// Variables.
		$this->settings = array(
			'name'		 => __( 'GDPR Cookie Notice & Compliance', 'gdprcono' ),
			'version'	 => '1.0.0',
			'menu_slug'	 => 'gdpr-cookie-notice-compliance',
			'permission' => 'manage_options',
			'basename'	 => plugin_basename( __FILE__ ),
			'path'		 => plugin_dir_path( __FILE__ ),
			'dir'		 => plugin_dir_url( __FILE__ )
        );
        
        // Language.
        add_action( 'plugins_loaded', array( $this, 'language_support' ) );

		// Actions (admin).
        add_action( 'admin_init', array( $this, 'admin_page_options_register' ) );
		add_action( 'admin_menu', array( $this, 'admin_page_url' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_page_styles_scripts' ) );

        // Actions (main).
        add_action( 'wp_enqueue_scripts', array( $this, 'main_styles_scripts' ) );
        add_action( 'init', array( $this, 'main' ) );

        if( ! is_admin() && 'hold' == $_COOKIE['gdprconostatus'] ) {
            add_action( 'wp_footer', array( $this, 'show_notifications' ) );
        }
    }
    
	/*
	*  language_support
	*
	*  @type	function
	*  @date	03/05/2020
	*  @since	1.0.0
	*/
	public function language_support() {
        load_plugin_textdomain( 'gdprcono', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
    }

	/*
	*  main
	*
	*  @type	function
	*  @date	03/05/2020
	*  @since	1.0.0
	*/
	public function main() {
        include( $this->settings['path'] . 'inc/gdpr-cookie-notice-helpers.php' );
        include( $this->settings['path'] . 'inc/gdpr-cookie-notice-shortcode.php' );
        include( $this->settings['path'] . 'inc/gdpr-cookie-notice-handler.php' );
        include( $this->settings['path'] . 'inc/gdpr-cookie-notice-template.php' );

        if( ! isset( $_COOKIE['gdprconostatus'] ) || empty( $_COOKIE['gdprconostatus'] ) ) {
            $host = parse_url( gdprcono_get_fullurl(), PHP_URL_HOST ); 
            setcookie( "gdprconostatus", "hold", time() + 172800, "/", $host );
        }

        if( 'reject' == $_COOKIE['gdprconostatus'] ) {
            gdprcono_clearall_cookies();
        }
    }

	/*
	*  show_notifications
	*
	*  @type	function
	*  @date	03/05/2020
	*  @since	1.0.0
	*/
	public function show_notifications() {
        gdprcono_display_notification_bar();
    }

	/*
	*  main_styles_scripts
	*
	*  @type	function
	*  @date	03/05/2020
	*  @since	1.0.0
	*/
	public function main_styles_scripts() {
        // Style.
        wp_enqueue_style( 'jquery-modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', array(), '0.9.1' );
        wp_enqueue_style( 'google-fonts-oswald', 'https://fonts.googleapis.com/css?family=Oswald&display=swap', array(), $this->settings['version'] );
        wp_enqueue_style( 'gdprcono-base', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', array( 'jquery-modal' ), $this->settings['version'] );

        // Build inline styles.
        $notice_bgcolor = get_option( 'gpdrcono_notice_bgcolor' );
        $notice_txtcolor = get_option( 'gpdrcono_notice_txtcolor' );

        $inline_styles = "
            .gdprcono-front__wrapper { 
                background-color: {$notice_bgcolor};
                color: {$notice_txtcolor};
            }
        ";

        wp_add_inline_style( 'gdprcono-base', $inline_styles );

        // Script.
        wp_enqueue_script( 'js-cookie', 'https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js', array( 'jquery' ), '3.0.0-beta.4' );
        wp_enqueue_script( 'jquery-modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', array( 'jquery', 'js-cookie' ), '0.9.1' ); 

        wp_register_script( 'gdprcono', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', array( 'js-cookie', 'jquery' ), $this->settings['version'] );
        wp_localize_script( 'gdprcono', 'gdprcono_handler_params', array( 'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php') );
        wp_enqueue_script( 'gdprcono' );
	}

	/*
	*  admin_page_url
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_page_url() {
		add_options_page(
			esc_html__( 'GDPR Cookie Notice & Compliance / Settings', 'gdprcono' ),
			esc_html__( 'GDPR Cookie Notice & Compliance', 'gdprcono' ),
			$this->settings['permission'], // capability
			$this->settings['menu_slug'],  // menu slug
			array( $this, 'admin_settings_page')
		);

		add_filter( 'plugin_action_links_' . $this->settings['basename'], array( $this, 'admin_settings_url') );
    }
    
	/*
	*  admin_page_options_register
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_page_options_register() {

        add_option( 'gpdrcono_headline_text', __( 
            'Denne hjemmeside anvender cookies til statistik og indstillinger. <br />
            Hvis du klikker videre på siden, accepterer du brugen af cookies.', 
            'gdprcono' ) 
        );
        register_setting( 'gdprcono_options_group', 'gpdrcono_headline_text' );

        add_option( 'gpdrcono_accept_text', esc_html__( 'OK', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_accept_text' );

        add_option( 'gpdrcono_reject_text', esc_html__( 'Nej, tak', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_reject_text' );

        add_option( 'gpdrcono_readmore_text', esc_html__( 'Læs mere', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_readmore_text' );

        add_option( 'gpdrcono_readmore_link' );
        register_setting( 'gdprcono_options_group', 'gpdrcono_readmore_link' );

        add_option( 'gpdrcono_notice_bgcolor', '#26487b' );
        register_setting( 'gdprcono_options_group', 'gpdrcono_notice_bgcolor' );

        add_option( 'gpdrcono_notice_txtcolor', '#ffffff' );
        register_setting( 'gdprcono_options_group', 'gpdrcono_notice_txtcolor' );

        // Privacy policy tab.
        add_option( 'gpdrcono_privacy_policy_page_switch', 'true' );
        register_setting( 'gdprcono_options_group', 'gpdrcono_privacy_policy_page_switch' );

        add_option( 'gpdrcono_privacy_policy_tab_title', esc_html__( 'Persondatapolitik', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_privacy_policy_tab_title' );

        $privacy_policy_content = '<strong>Persondatapolitik</strong>

        Ejeroplysninger
        Eteam.dk ApS
        Roskildevej 39, 3. sal.
        2000 Frederiksberg
        Telefon: <a href="tel: +4538423040">38 42 30 40</a>
        Mail: <a href="mailto:info@eteam.dk">info@eteam.dk</a>
        CVR: 37872628
        
        <strong>Hvilke persondata indsamler og behandler vi?</strong>
        
        Eteam.dk ApS indsamler og lagrer alle oplysninger, som du indtaster på vores hjemmesider, eller som du opgiver, når du benytter vores tjenester. Herudover indsamler vi oplysninger, som automatisk sendes til os fra dit udstyr.
        
        De oplysninger som vi indsamler kan omfatte, men er ikke begrænset til:
        <ul>
             <li>Oplysninger, som du opgiver, når du bliver oprettet som kunde/bruger eller benytter de tjenester, vi stiller til rådighed</li>
             <li>Oplysninger, der opgives i forbindelse med korrespondance via vores websted eller korrespondance, der sendes til os</li>
             <li>Yderligere oplysninger, som du måtte opgive via sociale medier eller andre tredjepartstjenester.</li>
        </ul>
        Udover de oplysninger, som du selv giver os, indsamler vi automatisk de oplysninger, der sendes til os fra din computer, mobilenhed eller andet udstyr.
        
        Disse oplysninger omfatter, men er ikke begrænset til:
        <ul>
             <li>Oplysninger om din interaktion med vores websteder og tjenester, herunder, men ikke begrænset til, enheds-id, enhedstype, oplysninger om geoplacering, computer-og forbindelsesoplysninger, statistik om sidevisninger, trafik til og fra vores hjemmeside, henvisnings-URL-adresse, IP-adresse og standardweblogoplysninger, og</li>
             <li>Oplysninger indsamlet via cookies og lignende teknologier.</li>
        </ul>
        <strong>Hvad bruger vi dine persondata til?</strong>
        
        Vi anvender de oplysninger vi har om dig til en række formål, herunder til at:
        <ul>
             <li>Behandle dine forespørgsler og ordrer</li>
             <li>Levere produkter, tjenester, service og kundesupport til dig</li>
             <li>Forbedre vores produkter, tjenester, service og hjemmesider</li>
             <li>Muliggøre din brug af vores tjenester og hjemmesider</li>
             <li>Tilpasse vores hjemmesider og tjenester til dig</li>
             <li>Få en bedre forståelse af, hvordan vores hjemmesider bruges, så vi kan forbedre dem</li>
             <li>Sende dig forretningsmæssige oplysninger, herunder ordrebekræftelser, fakturaer mv</li>
             <li>Sende dig nyhedsbreve og markedsføring pr. e-info, hvis du har afgivet samtykket</li>
             <li>Foretage markedsundersøgelser om vores kunder, deres interesser, om tendenser og kundeadfærd</li>
             <li>Administrere, diagnosticere og udbedre problemer på vores hjemmesider</li>
             <li>Forhindre eller fastslå ulovlig aktivitet ellerbeskytte eller håndhæve rettigheder, og</li>
             <li>Undgå eller imødegå sikkerhedsbrud.</li>
        </ul>
        Vi behandler og opbevarer kun data om dig, der er nødvendige, relevante og tilstrækkelige til at opfylde de formål, som er nævnt ovenfor. Vi lagrer ikke persondata længere end tilladt ved lov og sletter persondata, når de ikke længere er nødvendige til ovennævnte formål.
        
        <strong>Kontrol og opdatering af persondata</strong>
        
        Vi kontrollerer, at de persondata, vi behandler om dig, ikke er urigtige eller vildledende. Vi sørger også for at opdateredine persondata løbende. Da vores service er afhængig af, at dine data er korrekte og opdaterede, beder vi dig oplyse os om relevante ændringer i dine data.
        
        <strong>Indhentelse og tilbagetrækning af samtykke</strong>
        
        Vi indhenter dit samtykke, inden vi behandler dine persondata til de formål, der er beskrevet ovenfor, medmindre vi har et lovligt grundlag for at indhente dem. Vi oplyser dig om et sådant grundlag og om vores legitime interesse i at behandle dine persondata.
        
        Dit samtykke er frivilligt, og du kan til enhver tid trække det tilbage ved at henvende dig til os.
        
        <strong>Videregivelse af persondata</strong>
        
        Vi videregiver ikke persondata til tredjeparter, undtagen i følgende specifikke tilfælde:
        <ul>
             <li>Du har afgivet dit udtrykkelige samtykke til videregivelsen</li>
             <li>Videregivelsen sker tilbetroede virksomheder eller personer, der behandler persondata for os baseret på vores instrukser og i overensstemmelse med vores privatlivspolitik og andre gældende tiltag til fortrolighed og sikkerhed. Disse virksomheder eller personer har ikke tilladelse til at bruge dine oplysninger til deres egne formål</li>
             <li>Når vi er pålagt at videregive oplysninger i forbindelse med en vidneindkaldelse, retskendelse eller andre gældende lovmæssige eller juridiske processer</li>
             <li>Når vi i god tro mener, at videregivelsen af oplysninger er nødvendig for at forhindre eller reagere på bedrageri, forsvare vores hjemmesider mod angreb, eller beskytte vores virksomheds, kunders og brugeres ejendom og sikkerhed, eller offentlighedens sikkerhed.</li>
        </ul>
        Eteam.dk ApS videregiver ikke persondata om dig til tredjeparter med henblik på deres egne markedsføringsformål, medmindre du udtrykkeligt har samtykket til at oplysningerne må videregives til sådanne formål.
        
        Med disse parter er der indgået databehandleraftaler (DPA) iht. GDPR-forskrifterne herfor.
        
        <strong>Hvor lagres dine persondata?</strong>
        
        Personoplysningerne lagres hos os og vores databehandler, som opbevarer og behandler persondata på vores vegne i henhold til denne persondatapolitik og den gældende lovgivning om beskyttelse af persondata.Hvis vi videregiver dine persondata til samarbejdspartnere i Danmark eller tredjelande, sikrer vi os altid, at deres niveau for persondatabeskyttelse passer til de krav, vi har opstillet i denne privatlivspolitik og som følger af gældende lovgivning.
        
        <strong>Beskyttelseaf persondata</strong>
        
        Vi beskytter dine oplysninger ved hjælp af tekniske og administrative sikkerhedsforanstaltninger (f.eks. firewalls, datakryptering samt fysiske og administrative adgangskontroller til data og servere), som begrænser risikoen for tab, misbrug, uautoriseret adgang, videregivelse og ændring.
        
        <strong>Adgang til dine persondata</strong>
        
        Du har til en enhver tid ret til at få oplyst, hvilke data vi behandler om dig og hvad vi anvender dem til. Du kan også få oplyst, hvor længe vi opbevarer dine persondata, og hvem, der modtager data om dig, i det omfang vi videregiver data i Danmark og i udlandet.
        
        Hvis du anmoder om det, kan vi oplyse dig om til de data, vi behandler om dig. Adgangen kan dog være begrænset af hensyn til andre personers privatlivsbeskyttelse, til forretningshemmeligheder og immaterielle rettigheder.
        
        Du har også ret til at modtage de persondata, du har stillet til rådighed for os. Du har også ret til at overføre disse persondata til en anden tjenesteudbyde. Hvis du ønsker at bruge din ret til dataoverførsel, vil du modtage dine persondata fra os i et almindeligt anvendt format.
        
        <strong>Rettelse eller sletning af persondata</strong>
        
        Hvis du mener, at de persondata, vi behandler om dig, er forkerte, har du ret til at få dem rettet. Du skal blot henvende dig til os og oplyse, hvad du ønsker at få rettet.
        
        Hvis du mener, at dine persondata ikke længere er nødvendige i forhold til det formål, som vi indhentede dem til, eller hvis du hvis du mener, at dine persondata bliver behandlet i strid med lovgivningen eller andre retlige forpligtelser, kan du altid anmode om at få dem slettet.
        
        Når du henvender dig med en anmodning om at få rettet eller slettet dine persondata, undersøger vi, om betingelserne er opfyldt, og gennemfører i så fald ændringer eller sletning så hurtigt som muligt.
        
        <strong>Indsigelse eller klage mod behandling af persondata</strong>
        
        Du har ret til at gøre indsigelse mod vores behandling af dine persondata. Hvis din indsigelse er berettiget, sørger vi for at ophøre med behandlingen af dine persondata. Du har også ret til at klage over behandlingen af oplysninger og data vedrørende dig. Klage indgives til Datatilsynet.
        
        <strong>Ændring af privatlivspolitikken</strong>
        
        Vi forbeholder os ret til at ændre denne privatlivspolitik, således at vi til enhver tid overholder gældende lovgivning. Den senest opdaterede version af den til enhver tid gældende persondatapolitik kan findes på <a href="https://www.eteam.dk">www.eteam.dk</a>
        
        <strong>Har du kommentarer eller spørgsmål?</strong>
        
        Har du kommentarer eller spørgsmål vedrørende vores indsamling eller behandling af persondata, er du altid velkommen til at kontakte os på mail: <a href="mailto:info@eteam.dk">info@eteam.dk</a>';

        add_option( 'gpdrcono_privacy_policy_page', __( $privacy_policy_content ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_privacy_policy_page' );

        // Cookie required settings tab.
        add_option( 'gpdrcono_cookie_required_settings_switch', 'true' );
        register_setting( 'gdprcono_options_group', 'gpdrcono_cookie_required_settings_switch' );

        add_option( 'gpdrcono_cookie_required_settings_tab_title', esc_html__( 'Nødvendige cookies', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_cookie_required_settings_tab_title' );

        $cookie_policy_content = 'Visse typer cookies er nødvendige for at kunne levere f.eks. tjenester som du har anmodet om. Det kan eksempelvis være et kunde login.

        Disse typer cookies skal sørge for, at du får den bedst mulige oplevelse af vores hjemmeside. Cookies husker din navigation på siden, valg i bokse og lignende.
        
        Ingen af disse informationer kan personligt identificere dig.
        
        [gdprcono_cookie_switch_box]';

        add_option( 'gpdrcono_cookie_required_settings_tab_content', __( $cookie_policy_content ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_cookie_required_settings_tab_content' );

        // Cookie information tab.
        add_option( 'gpdrcono_cookie_information_switch', 'true' );
        register_setting( 'gdprcono_options_group', 'gpdrcono_cookie_information_switch' );

        add_option( 'gpdrcono_cookie_information_tab_title', esc_html__( 'Cookies oplysninger', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_cookie_information_tab_title' );

        $cookie_information_content = 'Vi bruger cookies til at indsamle statistik, der kan være med til at forbedre brugeroplevelsen.

        <span style="font-size: 1rem;">Cookies oplysninger gemmes i din browser og udfører diverse funktioner, så som f.eks. at genkende dig, når du vender tilbage til vores hjemmeside.</span>
        
        Du kan også vælge at justere dine cookies indstillinger ved hjælp af topfanerne her på siden.
        
        <a class="button" href="https://ec.europa.eu/info/law/law-topic/data-protection/reform/what-does-general-data-protection-regulation-gdpr-govern_da" target="_blank" rel="noopener">Læs mere om GDPR reglerne her</a>
        
        <strong>General information om brugen af cookies på denne hjemmeside.</strong>
        
        Ved at benytte denne hjemmeside accepterer du samtidig at siden bruger cookies.
        
        <strong>Hvad er cookies?</strong>
        Cookies er små tekstfiler, der gemmes i din browser, som gør at vi kan se at din computer, smartphone, iPad eller lignende har besøgt denne hjemmeside.
        Disse cookies har forskellige formål og kan eksempelvis bruges til at huske præferencer og føre statistik over besøgende på denne hjemmeside.
        
        Læs mere om cookies regler: <a href="https://erhvervsstyrelsen.dk/cookie-loven" target="_blank" rel="noopener">KLIK HER</a>
        
        <strong>Oversigt over hjemmesidens brug af cookies.</strong>
        
        <strong>Nødvendige cookies.</strong>
        Visse typer cookies er nødvendige for at kunne levere f.eks. tjenester som du har anmodet om. Det kan eksempelvis være et kunde login.
        
        <strong>Cookies til dine præferencer.</strong>
        Disse typer cookies skal sørge for, at du får den bedst mulige oplevelse af vores hjemmeside. Cookies husker din navigation på siden, valg i bokse og lignende. Ingen af disse informationer kan personligt  identificere dig.
        
        <strong>Cookies for optimering og drift.</strong>
        Disse typer cookies anvendes eksempelvis til at samle statistik om trafik til og fra hjemmesiden. Kun i begrænset omfang kan disse data identificere dig som bruger. Der bliver dog ikke gemt eller gjort brug af disse data og vi deler heller disse IKKE data med 3. part.
        
        Dataene anvendes bland andet i forbindelse med brugen af Google Analytics, Meta Trafik eller andre typer analyseprogrammer. Disse oplysninger går til servere, som kan være placeret i Danmark og i udlandet. Du kan fravælge cookies fra Google Analytics her: <a href="http://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">http://tools.google.com/dlpage/gaoptout</a>
        
        <strong>Sådan afviser du cookies.</strong>
        Ved at ændre indstillingerne i din browser, kan du afvise cookies på din computer. Hvordan du ændrer indstillingerne i din browser afhænger af, hvilken browser du anvender. Vælger du at indstille din browser, så du ikke modtager cookies, skal du være opmærksom på, at du kan gå glip af funktioner og lignende på hjemmesiden, som i så fald ikke vil fungere.
        
        <strong>Sådan sletter du dine cookies.</strong>
        Har du tidligere accepteret cookies, kan disse også slettes igen. Dette gøres i indstillingerne på din webbrowser.
        
        <strong>Fjern cookiefiler i browsere:
        </strong>Microsoft Edge: <a href="https://support.microsoft.com/da-dk/help/10607/microsoft-edge-view-delete-browser-history" rel="noopener">KLIK HER</a>
        Internet Explorer: <a href="https://support.microsoft.com/da-dk/help/278835/how-to-delete-cookie-files-in-internet-explorer" target="_blank" rel="noopener">KLIK HER</a>
        Chrome: <a href="https://support.google.com/chrome/answer/95647?co=GENIE.Platform%3DDesktop&amp;hl=da" target="_blank" rel="noopener">KLIK HER</a>
        Mozilla: <a href="https://support.mozilla.org/da/kb/slet-cookies-fjerne-oplysninger-fra-websteder" target="_blank" rel="noopener">KLIK HER</a>
        Opera: <a href="http://help.opera.com/Windows/12.10/en/cookies.html" target="_blank" rel="noopener">KLIK HER</a>
        Safari: <a href="https://support.apple.com/da-dk/HT1677" target="_blank" rel="noopener">KLIK HER</a>
        Flash cookies: <a href="http://www.macromedia.com/support/documentation/en/flashplayer/help/settings_manager07.html" target="_blank" rel="noopener">KLIK HER</a>
        Apple produkter: <a href="https://support.apple.com/da-dk/HT1677" target="_blank" rel="noopener">KLIK HER</a>';

        add_option( 'gpdrcono_cookie_information_tab_content', __( $cookie_information_content ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_cookie_information_tab_content' );

        // Switch box.
        add_option( 'gpdrcono_switch_activate_text', esc_html__( 'Aktiver cookies', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_switch_activate_text' );

        add_option( 'gpdrcono_switch_deactivate_text', esc_html__( 'Deaktiver cookies', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_switch_deactivate_text' );

        add_option( 'gpdrcono_switch_content', esc_html__( 
            'Hvis du deaktiverer denne cookies funktion, kan vi ikke gemme dine præferencer.<br />
             Det betyder, at hver gang du besøger denne hjemmeside, skal du aktivere eller deaktivere cookies igen.', 'gdprcono' ) 
        );
        register_setting( 'gdprcono_options_group', 'gpdrcono_switch_content' );
	}

	/*
	*  admin_settings_page
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_settings_page() {
		$this->admin_save_settings();
        include( $this->settings['path'] . 'admin/admin.php' );
    }
    
    /*
	*  admin_save_settings
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_save_settings() {
		// Check user capability.
		if( ! current_user_can( $this->settings['permission'] ) ) {
			return;
		}

		// Security token.
		if( ! ( isset( $_POST['_wpnonce'] ) && check_admin_referer( 'gdprcono_action', 'gdprcono_admin_nonce' ) ) ) {
			return;
        }

        // Update options.
        update_option( 'gpdrcono_headline_text', sanitize_text_field( $_POST['gpdrcono_headline_text'] ) );
        update_option( 'gpdrcono_accept_text', sanitize_text_field( $_POST['gpdrcono_accept_text'] ) );
        update_option( 'gpdrcono_reject_text', sanitize_text_field( $_POST['gpdrcono_reject_text'] ) );
        update_option( 'gpdrcono_readmore_text', sanitize_text_field( $_POST['gpdrcono_readmore_text'] ) );
	}

	/*
	*  admin_settings_url
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_settings_url( $url ) {
		$settings_url  = menu_page_url( $this->settings['menu_slug'], false );
		$settings_link = "<a href='{$settings_url}'>" . esc_html__( 'Settings', 'gdprcono' ) . "</a>";
		array_unshift( $url, $settings_link );

		return $url;
	}

	/*
	*  admin_page_styles_scripts
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_page_styles_scripts() {
        // Style.
        wp_enqueue_style( 'gdprcono-admin-base', plugin_dir_url( __FILE__ ) . 'assets/css/admin-style.css', array(), $this->settings['version'] );
        wp_enqueue_style( 'wp-color-picker' );

		// Script.
		wp_enqueue_script( 'gdprcono-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin-script.js', array( 'jquery', 'wp-color-picker' ), $this->settings['version'] );
	}
}

/*
*  gdpr_cookie_notice_compliance
*
*  The main function responsible for returning the one true gdpr_cookie_notice_compliance Instance to functions everywhere.
*  Use this function like you would a global variable, except without needing to declare the global.
*
*  Example: <?php $gdpr_cookie_notice_compliance = gdpr_cookie_notice_compliance(); ?>
*
*  @type	function
*  @date	03/04/2020
*  @since	1.0.0
*
*  @param	N/A
*  @return	(object)
*/

function gdpr_cookie_notice_compliance() {
	global $gdpr_cookie_notice_compliance;
	if( ! isset( $gdpr_cookie_notice_compliance ) ) {
		$gdpr_cookie_notice_compliance = new gdpr_cookie_notice_compliance();
		$gdpr_cookie_notice_compliance->initialize();
	}

	return $gdpr_cookie_notice_compliance;
}

// initialize.
gdpr_cookie_notice_compliance();


endif; // class_exists check.