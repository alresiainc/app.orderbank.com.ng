//Add this to the user timezone_abbreviations_listTable seller {
id INT [pk, increment] // Primary Key
slug
company_name VARCHAR(255) // User's full name
company_logo
company_email VARCHAR(255) // User's email address
company_phone_number
user_id INT [users.id]
country
state
city
address_line_1
address_line_2
profile_link
postal_code
kyc_state
timezone
status ENUM('active', 'inactive') [default: 'active'] // Account status
created_at DATETIME [default: ⁠ CURRENT_TIMESTAMP ⁠]
updated_at DATETIME [default: ⁠ CURRENT_TIMESTAMP ⁠]
}

Table seller {
id INT [pk, increment] // Primary Key
slug
company_name VARCHAR(255) // User's full name
company_logo
company_email VARCHAR(255) // User's email address
company_phone_number
user_id INT [users.id]
country
state
city
address_line_1
address_line_2
profile_link
postal_code
kyc_state
timezone
status ENUM('active', 'inactive') [default: 'active'] // Account status
created_at DATETIME [default: ⁠ CURRENT_TIMESTAMP ⁠]
updated_at DATETIME [default: ⁠ CURRENT_TIMESTAMP ⁠]
}