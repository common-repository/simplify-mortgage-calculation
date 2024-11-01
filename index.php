<?php
/**
 * Plugin Name: Simplify Mortgage Calculation
 * Plugin URI: http://souravmondal.co.in
 * Description: Calculate how much you can afford spending per month on your mortgage/loan payment with this plugin
 * Version: 2.0.0
 * Author: Sourav Mondal
 * Author URI: http://souravmondal.co.in
 * Tags: mortgage calculator,Simplify Mortgage Calculation,loan calculator,real estate,affordability,affordability calculator
 * License: GPL2
 */
define('MORGCAL_PLUGIN_URL', plugin_dir_url(__FILE__));

function load_mortgage_assets() {
    wp_enqueue_style('morcalculatorstyle', MORGCAL_PLUGIN_URL . 'mortgage-app-style.css');
    wp_enqueue_script('morapplication', MORGCAL_PLUGIN_URL . 'mortgage-app-script.js', array('jquery'), "1.0.0", TRUE);
}

add_action('wp_enqueue_scripts', 'load_mortgage_assets');

class Mortgage_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
                'mortgage_widget', // Base ID
                'Mortgage_Calculation', // Name
                array('description' => __('A simple Mortgage Calculator', 'custom-text_domain'),) // Args
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];
        $html_content = '
                <div class="MortCal">
                <label>Purchase Price/Loan Amount($)</label>
                <input type="text" name="loan_amount_mrg" id="loan_amount_mrg" placeholder="Enter Loan Amount" />
                <label>Downpayment($)</label>
                <input type="text" name="down_payment_mrg" id="down_payment_mrg" placeholder="Initial Payment" />
                <label>Mortgage Term (Months)</label>
                <input type="text" name="years_mrg" id="years_mrg" placeholder="Months of Installment" />
                <label>Interest Rate(%)</label>
                <input type="text" name="interest_mrg" id="interest_mrg" placeholder="Enter Interest Rate" />
                <input type="button" name="calculateloan" id="calculateloan" class="loanbutton" value="Calculate" />
                <input type="button" name="resetmrg" id="resetmrg" value="Reset" class="loanbutton"/>
                <br class="clear"/>
                <div class="showresultmor" id="showresultmor">Result of Calculation</div>
                </div>';
        echo __($html_content, 'custom-text_domain');
        echo $args['after_widget'];
    }

    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Mortgage Calculator', 'custom-text_domain');
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            <br/>
            <span>Plugin Developed By:</span>
            <span>Sourav Mondal</span>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}

// class Foo_Widget

/** registring widget */
function Mortgage_Widget_register() {
    register_widget('Mortgage_Widget');
}

add_action('widgets_init', 'Mortgage_Widget_register');

function Mortgage_Shortcode_function() {
    $html_content = '
                <div class="MortCal">
                <label class="morhdcls">Mortgage Calculator</label>
                <br class="clear" />
                <label>Purchase Price/Loan Amount($)</label>
                <input type="text" name="loan_amount_mrg" id="loan_amount_mrg" placeholder="Enter Loan Amount" />
		<br class="clear" />
                <label>Downpayment($)</label>
                <input type="text" name="down_payment_mrg" id="down_payment_mrg" placeholder="Initial Payment" />
                <label>Mortgage Term (Months)</label>
                <input type="text" name="years_mrg" id="years_mrg" placeholder="Months of Installment" />
		<br class="clear" />
                <label>Interest Rate(%)</label>
                <br class="clear" />
                <input type="text" name="interest_mrg" id="interest_mrg" placeholder="Enter Interest Rate" />
                <input type="button" name="calculateloan" id="calculateloan" class="loanbutton" value="Calculate" />
                <input type="button" name="resetmrg" id="resetmrg" value="Reset" class="loanbutton"/>
                <br class="clear"/>
                <div class="showresultmor" id="showresultmor">Result of Calculation</div>
                </div>';
    return $html_content;
}

add_shortcode('Mortgage_Calculator', 'Mortgage_Shortcode_function');
?>
