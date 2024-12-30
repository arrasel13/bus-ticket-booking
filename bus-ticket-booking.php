<?php

/**
 * Plugin Name: Bus Ticket Booking
 * Description: This is a sample plugin. Feel free to use as template.
 * Plugin URI: https://profiles.wordpress.org/arrasel403/
 * Author: AR Rasel
 * Author URI: https://profiles.wordpress.org/arrasel403/
 * Version: 0.0.1
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Bus_Ticket_Booking
{

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.0';

    /**
     * Class construcotr
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Initialize a singleton instance
     *
     * @return \Bus_Ticket_Booking
     */
    public static function init()
    {
        static $instance = false;

        if (! $instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('BUS_TICKET_BOOKING_VERSION', self::version);
        define('BUS_TICKET_BOOKING_FILE', __FILE__);
        define('BUS_TICKET_BOOKING_PATH', __DIR__);
        define('BUS_TICKET_BOOKING_URL', plugins_url('', BUS_TICKET_BOOKING_FILE));
        define('BUS_TICKET_BOOKING_ASSETS', BUS_TICKET_BOOKING_URL . '/assets');
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin()
    {

        new BusTicketBooking\Assets();

        if (defined('DOING_AJAX') && DOING_AJAX) {
            new BusTicketBooking\Ajax();
        }

        if (is_admin()) {
            new BusTicketBooking\Admin();
        } else {
            new BusTicketBooking\Frontend();
        }

        new BusTicketBooking\API();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate()
    {
        $installer = new BusTicketBooking\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Bus_Ticket_Booking
 */
function bus_ticket_booking()
{
    return Bus_Ticket_Booking::init();
}

//call the plugin
bus_ticket_booking();
