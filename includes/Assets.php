<?php

namespace BusTicketBooking;

/**
 * Assets handler class
 */
class Assets
{

    /**
     * Class constructor
     */
    function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
        add_action('admin_enqueue_scripts', [$this, 'register_assets']);
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts()
    {
        return [
            'bus-ticket-booking-script' => [
                'src'     => BUS_TICKET_BOOKING_ASSETS . '/js/frontend.js',
                'version' => filemtime(BUS_TICKET_BOOKING_PATH . '/assets/js/frontend.js'),
                'deps'    => ['jquery']
            ],
            'bus-ticket-booking-admin-script' => [
                'src'     => BUS_TICKET_BOOKING_ASSETS . '/js/admin.js',
                'version' => filemtime(BUS_TICKET_BOOKING_PATH . '/assets/js/admin.js'),
                'deps'    => ['jquery', 'wp-util']
            ],
        ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles()
    {
        return [
            'bus-ticket-booking-style' => [
                'src'     => BUS_TICKET_BOOKING_ASSETS . '/css/frontend.css',
                'version' => filemtime(BUS_TICKET_BOOKING_PATH . '/assets/css/frontend.css')
            ],
            'bus-ticket-booking-admin-style' => [
                'src'     => BUS_TICKET_BOOKING_ASSETS . '/css/admin.css',
                'version' => filemtime(BUS_TICKET_BOOKING_PATH . '/assets/css/admin.css')
            ],
        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets()
    {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ($scripts as $handle => $script) {
            $deps = isset($script['deps']) ? $script['deps'] : false;

            wp_register_script($handle, $script['src'], $deps, $script['version'], true);
        }

        foreach ($styles as $handle => $style) {
            $deps = isset($style['deps']) ? $style['deps'] : false;

            wp_register_style($handle, $style['src'], $deps, $style['version']);
        }

        wp_localize_script('bus-ticket-booking-admin-script', 'busTicketBooking', [
            'nonce' => wp_create_nonce('bus-ticket-booking-admin-nonce'),
            'confirm' => __('Are you sure?', 'bus-ticket-booking'),
            'error' => __('Something went wrong', 'bus-ticket-booking'),
        ]);
    }
}
