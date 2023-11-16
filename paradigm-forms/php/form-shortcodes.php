<?php

// Create shortcode for button and modal
function paradigm_forms_shortcode() {
    ob_start();
    ?>

    <div id="paradigm-forms-container">

        <form id="paradigm-form">
            <!-- This is the honeypot field -->
            <div style="display: none;">
                <label for="fax">Fax (do not fill out)</label>
                <input type="text" id="fax" name="fax">
            </div>
            <div class="display-flex">
                <div class="one-half-column content-left display-flex flex-direction-column">
                <label for="first-name">FIRST NAME *</label>
                <input type="text" id="first-name" name="first-name" required>
                </div>
                <div class="one-half-column content-right display-flex flex-direction-column">
                <label for="last-name">LAST NAME *</label>
                <input type="text" id="last-name" name="last-name" required>
                </div>
            </div>
            <div class="display-flex">
                <div class="one-half-column content-left display-flex flex-direction-column">
                <label for="email">EMAIL ADDRESS *</label>
                <input type="email" id="email" name="email" required>
                </div>
                <div class="one-half-column content-right display-flex flex-direction-column">
                <label for="phone-number">PHONE NUMBER *</label>
                <input type="tel" id="phone-number" name="phone-number" required>
                </div>
            </div>
            <div class="form-field">
                <label for="procedure-of-interest">PROCEDURE OF INTEREST *</label>
                <input type="text" id="procedure-of-interest" name="procedure-of-interest" required>
            </div>
            <div class="form-field">
                <label for="referral">HOW DID YOU HEAR ABOUT US? *</label>
                <input type="text" id="referral" name="referral" required>
            </div>
            <div class="form-field">
                <label for="form-message">MESSAGE</label>
                <textarea id="form-message" name="form-message" rows="5"></textarea>
            </div>
            <div class="paradigm-forms-button">
                <input type="submit" id="submit" value="SUBMIT">
            </div>
        </form>
        <div>
            <p id="paradigm-form-received" class="hidden">Submission Received.</p>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('paradigm_forms', 'paradigm_forms_shortcode');


// Create shortcode for button and modal
function paradigm_forms_sidebar_shortcode() {
    ob_start();
    ?>

    <div id="paradigm-forms-sidebar-container">

    <div>
        <p class="text-large">Request Consultation</p>
    </div>

        <form id="paradigm-form">
            <!-- This is the honeypot field -->
            <div style="display: none;">
                <label for="fax">Fax (do not fill out)</label>
                <input type="text" id="fax" name="fax">
            </div>
            <div class="form-field">
                <label for="first-name">FIRST NAME *</label>
                <input type="text" id="first-name" name="first-name" required>
            </div>
            <div class="form-field">
                <label for="last-name">LAST NAME *</label>
                <input type="text" id="last-name" name="last-name" required>
            </div>
            <div class="form-field">
                <label for="email">EMAIL ADDRESS *</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-field">
                <label for="phone-number">PHONE NUMBER *</label>
                <input type="tel" id="phone-number" name="phone-number" required>
            </div>
            <div class="form-field">
                <label for="procedure-of-interest">PROCEDURE OF INTEREST *</label>
                <input type="text" id="procedure-of-interest" name="procedure-of-interest" required>
            </div>
            <div class="form-field">
                <label for="referral">HOW DID YOU HEAR ABOUT US? *</label>
                <input type="text" id="referral" name="referral" required>
            </div>
            <div class="form-field">
                <label for="form-message">MESSAGE</label>
                <textarea id="form-message" name="form-message" rows="5"></textarea>
            </div>
            <div class="paradigm-forms-button">
                <input type="submit" id="submit" value="SUBMIT">
            </div>
        </form>
        <div>
            <p id="paradigm-form-received" class="hidden">Submission Received.</p>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('paradigm_forms_sidebar', 'paradigm_forms_sidebar_shortcode');