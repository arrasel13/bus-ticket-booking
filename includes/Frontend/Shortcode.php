<?php

namespace BusTicketBooking\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode
{

    /**
     * Initialize the class
     */
    function __construct()
    {
        add_shortcode('bus-ticket-booking', [$this, 'render_shortcode']);
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_shortcode($atts, $content = '')
    {
        wp_enqueue_script('bus-ticket-booking-script');
        wp_enqueue_style('bus-ticket-booking-style');

        return '<div class="bus-ticket-booking-shortcode">Hello from Shortcode</div>';
    }
}
