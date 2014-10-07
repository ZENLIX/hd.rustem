<?php 
function lang ($phrase) {
	static $lang = array (
	
'ALLSTATS_main' => 'General Statistics',
'ALLSTATS_help' => 'This section contains statistics of all departments and their users for which you have permissions.',
'ALLSTATS_unit' => 'Information about the applications of your departments',
'ALLSTATS_unit_free' => 'Free bids',
'ALLSTATS_unit_lock' => 'Busy applications',
'ALLSTATS_unit_ok' => 'Executed orders',
'ALLSTATS_user' => 'Current information on the applications of users of your departments',
'ALLSTATS_user_fio' => 'Name',
'ALLSTATS_user_free' => 'Free',
'ALLSTATS_user_lock' => 'blocking',
'ALLSTATS_user_ok' => 'Executed',
'ALLSTATS_user_out_all' => 'Create (of)',
'ALLSTATS_user_out_all_not' => 'Create (not performance)',
'stats_last_time'=>'Last login: ',
	
	
	
	'NAVBAR_files'=>'Ticket\' files',  
'T_from'=>'from',
'FILES_title' => 'Files of applications',
'FILES_off' => 'Currently disabled downloading files to applications. To activate,  <a href="./config">go here </a> and activate downloading files to the application. ',
'FILES_info' => 'In this section you can view all the attachments to the applications, as well as remove them.',
'FILES_name' => 'Filename',
'FILES_ticket' => 'Application',
'FILES_size' => 'Size',
'FILES_del'=>'Delete',
'FILES_down'=>'Download',

'CONF_file_types'=>'Permitted file types',
'CONF_file_size'=>'Maximum file size',
	
	
	 'DEPS_off'=>'Currently disabled fixed list of those applications. To enable it,  <a href="./config">go here </a> applications and select the theme "fixity" list.', 
	 
'TICKET_t_a_e_prio'=>'in the application has been changed the priority',

	 
	    'CONF_info'=>'This section contains the basic system configuration.',
'CONF_title' => 'System Settings',
'CONF_mains' => 'General Settings',
'CONF_name' => 'Name of Organization',
'CONF_title_org' => 'Title of the system',
'CONF_url' => 'URL of the system',
'CONF_2arch' => 'How many days a request to the archive',
'CONF_2arch_info' => 'For automatic migration of applications to the archive, add a cron-scheduler line:',
'CONF_f_login' => 'The first input and activation',
'CONF_f_login_opt_true' => 'Available link',
'CONF_false' => 'Inactive',
'CONF_f_login_info' => 'If you already have a user base (or rather their email), each new users will enter email, and if it already is in the database, then it will be sent a password. This eliminates the administrator create a password and activation uchёtok. ',
'CONF_subj' => 'Topics applications',
'CONF_fix_list' => 'fixity list',
'CONF_subj_text' => 'Input field',
'CONF_subj_info' => 'When creating applications, you can define the fixity of themes or text box that fits the topic name of the application.',
'CONF_fup' => 'Upload files to the application',
'CONF_true' => 'active',
'CONF_fup_info' => 'The ability to attach files to the application.',
'CONF_act_edit' => 'Edit',

'CONF_mail_name' => 'Mail Settings',
'CONF_mail_status' => 'Email notifications',
'CONF_mail_host' => 'Address SMTP-server',
'CONF_mail_port' => 'Port SMTP-server',
'CONF_mail_auth' => 'Authorization',
'CONF_mail_type' => 'Authentication type',
'CONF_mail_login' => 'Username',
'CONF_mail_pass' => 'Password',
'CONF_mail_from' => 'Opravitel',
'CONF_mail_debug' => 'Debug mode',
 'CONF_mail'=>'E-mail of admin',
	'CONF_mail_type'=>'Type',
	 'HELPER_info'=>'This section can contain instructions and documentation for solutions to common problems.',
	
	
	
	
	'LIST_pin' => 'Units',
	'DASHBOARD_TITLE' => 'Dashboard',
	'DASHBOARD_ticket_stats' => 'Statistics Tickets',
	'DASHBOARD_ticket_in_desc' => 'Incoming free Ticket that you can take',
	'DASHBOARD_ticket_in' => 'incoming requests',
'DASHBOARD_ticket_lock' => 'blocked me',
'DASHBOARD_ticket_lock_desc' => 'Ticket with which you are working',
'DASHBOARD_ticket_out' => 'outgoing ticket',
'DASHBOARD_ticket_out_desc' => 'Tickets you have created and have remained unfulfilled',
'DASHBOARD_last_news' => 'Recent changes',
'DASHBOARD_last_help' => 'Last of the Knowledge Center',
'DASHBOARD_author' => 'Author',
'DASHBOARD_last_in' => 'Last inbound tickets',
 'APPROVED_info' => 'This section contains a query system users to change information about the client (user).',
  'WORKERS_info' => 'This section contains information about the users (clients), you can find and send the request to change the information. If you have sufficient rights, you can change the information immediately, without asking.',
'NEW_title' => 'Create a new request',
'NEW_ok' => 'The Ticket was successfully created!',
'NEW_ok_1' => 'You can',
'NEW_ok_2' => 'share link',
'NEW_ok_3' => 'on request or',
'NEW_ok_4' => 'print it',
'NEW_from' => 'From',
'DEPS_info'=>'This section contains the departments that are users of the system. <br> When you create an application, you can choose one of these departments.',
'POSADA_info'=>'This section contains the position of users (clients). <br> When creating the application, if you have the right to edit / add users (customers), you can specify the position.',
'UNITS_info'=>'This section contains the units of users (clients). <br> When creating the application, if you have the right to edit / add users (customers), you can specify the units.',
'SUBJ_info'=>'This section contains topics applications. <br> When you create an application, you can choose the theme of the application.',
'NEW_from_desc' => 'Your name or username of the user who asked for help',
'NEW_fio' => 'name or user login',
'NEW_fio_desc' => 'Please fill this field',
'NEW_to' => 'To',
'NEW_to_desc' => 'Receiver Tickets - or an entire department, or optionally a specific employee.',
'NEW_to_unit' => 'Department',
'NEW_to_unit_desc' => 'Specify the destination or department employee',
'NEW_to_user' => 'Receiver',
'NEW_prio' => 'Priority',
'NEW_prio_low' => 'Low',
'NEW_prio_norm' => 'Average',
'NEW_prio_high' => 'High',
'NEW_prio_high_desc' => 'will be used SMS-information',
'NEW_subj' => 'Subject',
'NEW_subj_msg' => 'Specify the subject of the Ticket',
'NEW_subj_det' => 'Title ticket',
'NEW_MSG' => 'text',
'NEW_MSG_msg' => 'Please provide details are ticket',
'NEW_MSG_ph' => 'The essence of the ticket',
'NEW_button_create' => 'New Ticket',
'NEW_button_reset' => 'Clear Fields',
'LIST_title' => 'List of orders',
'LIST_ok_t' => 'Ticket is made',
'LIST_lock_t_i' => 'Ticket with which you are working',
'LIST_lock_t' => 'Ticket with which the work',
'LIST_lock_n' => 'Ticket number',
'LIST_find_ph' => 'Enter # or ticket subject or text of the application, or text comment',
'LIST_find_button' => 'Search',
'LIST_in' => 'Inbox',
'LIST_out' => 'Outgoing',
'LIST_arch' => 'Archive',
'LIST_loading' => 'Loading',
'CREATE_ACC_success' =>' Your account has been successfully activated! <br> to your email sent to your login and password. ',
'msg_created_new_user' => 'This will create a new user',
'CREATE_ACC_already' => 'Your account has been activated.',
'CREATE_ACC_error' => 'User with this email address is not found.',
'MAIN_TITLE' => 'Ticket System',
'AUTH_USER' => 'Authorization',
'login' => 'Login',
'pass' => 'Password',
'remember_me' => 'Remember me',
'error_auth' => 'Error. <br> Check username and password. ',
'first_in_auth' => 'The first input and activation',
'user_auth' => 'User activation',
'work_mail' => 'your desktop e-mail', 
'action_auth' => 'Activate',
'log_in' => 'Login',
'work_mail_ph' => 'Enter your work e-mail (e-mail).', 
'NOTES_single' => 'Record ...',
't_LIST_prio' => 'Priority',
't_LIST_subj' => 'Subject', 
// <? = Lang ('t_LIST_prio'); 
't_LIST_worker' => 'User',
't_LIST_create' => 'Created',
't_LIST_ago' => 'passed',
't_LIST_init' => 'Author',
't_LIST_to' => 'Receiver' 
,'t_LIST_status' => 'Status' 
,'t_LIST_action' => 'Action' 
,'t_list_a_nook' => 'mark is formed' 
,'t_list_a_unlock' => 'unlock' 
,'t_list_a_lock' => 'block' 
,'t_list_a_ok' => 'execute' 
,'t_list_a_all' => 'All' 
,'t_list_a_user_ok' => 'Completed' 
,'t_list_a_date_ok' => 'Done' 
,'t_list_a_p_norm' => 'medium priority' 
,'t_list_a_p_low' => 'low priority' 
,'t_list_a_p_high' => 'high priority' 
,'t_list_a_oko' => 'satisfied' 
,'t_list_a_arch' => 'archive' 
,'t_list_a_lock_i' => 'I work' 
,'t_list_a_lock_u' => 'works' 
,'t_list_a_hold' => 'expectations of action' 
,'t_list_a_ok_no' => 'yes / no' 

,'HELP_desc' => 'Description of the problem' 
,'HELP_do' => 'Solution' 
,'HELP_save' => 'Save' 
,'HELP_back' => 'Back' 
,'HELP_all' => 'All' 
,'HELP_create' => 'Create' 
,'MSG_no_records' => 'No entries' 
,'TICKET_name' => 'Ticket' 


,'TICKET_p_add_client'=>'Add clients',
'TICKET_p_edit_client'=>'Edit clients'
,'USERS_profile_priv'=>'Access to view tickets'

,'WORKER_TITLE' => 'About' 
,'WORKER_fio' => 'Name' 
,'WORKER_login' => 'Login' 
,'WORKER_posada' => 'Position' 
,'WORKER_unit' => 'Category' 
,'WORKER_tel' => 'Phone' 
,'WORKER_tel_full' => 'Telephone' 
,'WORKER_room' => ' Office' 
,'WORKER_mail' => 'E-mail' 
,'WORKER_total' => 'Tickets' 
,'WORKER_last' => 'Last' 
,'WORKER_edit_info' => 'Edit Information' 
,'WORKER_send_approve' => 'Send a request to change' 

,'PROFILE_msg_ok' => 'Data successfully updated.' 
,'PROFILE_msg_error' => 'Username or e-mail does not have the correct format.' 
,'PROFILE_msg_pass_err' => 'Old password is incorrect.' 
,'PROFILE_msg_pass_err2' => 'New passwords do not match.' 
,'PROFILE_msg_pass_err3' => 'Password must be at least 4 characters.' 
,'PROFILE_msg_pass_ok' => 'Password successfully changed. Need <a href=\'index.php\'> log in again </ a>. ' 
,'PROFILE_msg_te' => 'Error'
,'PROFILE_priv'=>'Your access to system as'
,'PROFILE_priv_unit'=>'Access to units'

,'TABLE_name' => 'Name' 
,'TABLE_action' => 'Action' 
,'PROFILE_msg_send' => 'request to change the user information has been sent. Changes will be implemented only after validation. '

,'TICKET_msg_OK' => 'Ticket is made' 
,'TICKET_msg_OK_error' => 'can not be performed. Ticket has already been performed by the user '
,'TICKET_msg_unOK' => 'Request failed' 
,'TICKET_msg_unOK_error' => 'Can not' 
,'TICKET_msg_lock' => 'Ticket locked' 
,'TICKET_msg_lock_error' => 'Unable to lock the Ticket. With her works' 
,'TICKET_msg_unlock' => 'Ticket unlocked' 
,'TICKET_msg_refer' => 'Ticket redirected' 
,'empty' => 'empty' 
,'t_list_a_top' => 'TOP 10 search results' 


,'TICKET_status_arch' => 'Ticket in the archive' 
,'TICKET_status_ok' => 'Ticket is performed by the user' 
,'TICKET_status_lock' => 'work with the Ticket' 
,'TICKET_status_new' => 'new order, waiting action' 

,'TICKET_action_unlock' => 'Restore' 
,'TICKET_action_lock' => 'Block' 
,'TICKET_action_ok' => 'Done' 
,'TICKET_action_nook' => 'not satisfied' 
,'TICKET_msg_updated' => 'The Ticket has been updated.' 

,'TICKET_t_from' => 'Author' 
,'TICKET_t_was_create' => 'has been created' 
,'TICKET_t_to' => 'Receiver' 
,'TICKET_t_last_edit' => 'Revised' 
,'TICKET_t_worker' => 'User' 
,'TICKET_t_last_up' => 'Last update' 
,'TICKET_t_status' => 'Status' 
,'TICKET_t_prio' => 'Priority' 
,'TICKET_t_subj' => 'Subject' 
,'TICKET_t_refer' => 'Forwarding' 
,'TICKET_t_refer_to' => 'Redirecting to' 
,'TICKET_t_opt' => 'optional' 
,'TICKET_t_in_arch' => 'Ticket stored in the archive.' 
,'TICKET_t_ok' => 'Ticket is successful the user' 
,'TICKET_t_ok_1' => 'After some time, the Ticket will go to the archives.' 
,'TICKET_t_lock' => 'At the moment the user is working with the Ticket' 
,'TICKET_t_lock_1' => 'So you can not work with the Ticket.' 
,'TICKET_t_lock_i' => 'You are currently working with the Ticket. In order for others to work and release it. '
,'TICKET_t_comment' => 'Comments' 
,'TICKET_t_history' => 'Change History' 
,'TICKET_t_your_comment' => 'Your comments' 
,'TICKET_t_det_ticket' => 'Please provide details are ticket' 
,'TICKET_t_comm_ph' => 'Comment to the Ticket' 
,'TICKET_t_send' => 'Send' 
,'TICKET_t_date' => 'Date' 
,'TICKET_t_init' => 'Author' 
,'TICKET_t_action' => 'Action' 
,'TICKET_t_desc' => 'Description'
,'TICKET_t_a_refer' => 'Ticket is redirected to' 
,'TICKET_t_a_arch' => 'Ticket is moved to the archive' 
,'TICKET_t_a_ok' => 'Ticket marked as done' 
,'TICKET_t_a_nook' => 'Ticket is marked as failed' 
,'TICKET_t_a_lock' => 'Ticket locked' 
,'TICKET_t_a_unlock' => 'Ticket unlocked' 
,'TICKET_t_a_create' => 'Ticket was made' 
,'TICKET_t_a_e_text' => 'in the Ticket has been changed message' 
,'TICKET_t_a_e_subj' => 'in the Ticket has been modified theme' 
,'TICKET_t_a_com' => 'Ticket was commented' 
,'TICKET_t_no' => 'No such Ticket',
'TICKET_error_msg'=>'<strong>Sorry!</strong> You don\'t have access to add client.'

,'CLIENTS_name' => 'People' 
,'CLIENTS_find' => 'Find' 
,'CLIENTS_find_me' => 'Please search for editing information ...' 


,'NAVBAR_tickets' => 'Tickets' 
,'NAVBAR_create_ticket' => 'New Ticket' 
,'NAVBAR_list_ticket' => 'List of orders' 
,'NAVBAR_workers' => 'People' 
,'NAVBAR_helper' => 'Knowledge Centre' 
,'NAVBAR_notes' => 'Notebook' 
,'NAVBAR_admin' => 'Administration' 
,'NAVBAR_users' => 'system users' 
,'NAVBAR_deps' => 'Departments' 
,'NAVBAR_approve' => 'Confirm' 
,'NAVBAR_all_tickets' => 'All Tickets' 
,'NAVBAR_reports' => 'Reports' 
,'NAVBAR_db' => 'Directories' 
,'NAVBAR_posads' => 'Posts' 
,'NAVBAR_units' => 'Manage' 
,'NAVBAR_subjs' => 'Topics Tickets' 
,'NAVBAR_profile' => 'Profile' 
,'NAVBAR_help' => 'Help' 
,'NAVBAR_logout' => 'Exit' 
,'TICKET_file_startupload'=>'start upload'
,'upload_not_u' => 'You are not upload some files'

,'TICKET_ACTION_refer' => 'redirect the user' 
,'TICKET_ACTION_refer_to' => 'on' 
,'TICKET_ACTION_ok' => 'performed by the user' 
,'TICKET_ACTION_nook' => 'not performed by the user' 
,'TICKET_ACTION_lock' => 'user locked' 
,'TICKET_ACTION_unlock' => 'unblock' 
,'TICKET_ACTION_create' => 'user-created' 
,'TICKET_ACTION_edit' => 'changed by the user' 
,'TICKET_ACTION_comment' => 'user commented' 
,'TICKET_ACTION_arch' => 'Ticket is moved to the archive' 


,'HELPER_title' => 'Knowledge Centre' 
,'HELPER_back' => 'back'
,'HELPER_print'=>'print'
,'HELPER_pub' => 'Published' 
,'HELPER_date' => 'Date' 
,'HELPER_find' => 'Find' 
,'HELPER_create' => 'create a new record' 
,'HELPER_desc' => 'Description of the issue or issues ...' 


,'NOTES_title' => 'Personal Favorites' 
,'NOTES_link' => 'Link to Record' 
,'NOTES_create' => 'create a new record' 
,'NOTES_cr' => 'Add New or select ...' 


,'P_title' => 'Edit Information' 
,'P_main' => 'General Information' 
,'P_login' => 'Login' 
,'P_mail' => 'E-mail' 
,'P_mail_desc' => 'is used exclusively for the notice.' 
,'P_edit' => 'Save' 
,'P_passedit' => 'Change Password' 
,'P_pass_old' => 'Old password' 
,'P_pass_old2' => 'Password old' 
,'P_pass_new' => 'New Password' 
,'P_pass_new2' => 'new password' 
,'P_pass_new_re' => 'Confirm new password' 
,'P_pass_new_re2' => 'new Password (again)' 
,'P_do_edit_pass' => 'Change Password' 

,'JS_not_found' => 'Not found ...' 
,'JS_ticket' => 'Ticket' 
,'JS_up' => 'Updated!' 
,'JS_save' => 'Save' 
,'JS_pub' => 'Post' 
,'JS_del' => 'Do you really want to delete?' 
,'JS_create' => 'Add New or select ...' 
,'JS_low' => 'Low' 
,'JS_norm' => 'Average' 
,'JS_high' => 'High' 
,'JS_unit' => 'Please fill in the unit' 
,'JS_probl' => 'Please fill in the description of the problem' 
,'JS_ok' => 'Done' 
,'JS_no_ok' => 'not satisfied' 
,'JS_unlock' => 'Restore' 
,'JS_lock' => 'Block' 

,'PROFILE_msg_add'=>'User (client) added success'

,'USERS_title' => 'People of system' 
,'USERS_create' => 'Create User' 
,'USERS_list' => 'People' 

,'USERS_msg_add' => 'User added successfully!' 
,'USERS_new' => 'New user' 
,'USERS_fio' => 'Name' 
,'USERS_fio_full' => 'surname, name and patronymic' 
,'USERS_login' => 'Login' 
,'USERS_pass' => 'Password' 
,'USERS_mail' => 'E-mail' 
,'USERS_units' => 'Departments' 
,'USERS_unit' => 'Department' 
,'USERS_nach1' => 'Head' 
,'USERS_nach1_desc' => 'Will see all Tickets.' 
,'USERS_nach' => 'Head of Department' 
,'USERS_nach_desc' => 'Will see all Tickets addressed in selected departments, as well as addressing all the users of the department.' 
,'USERS_wo' => 'Employee' 
,'USERS_wo_desc' => 'Will see all Tickets, addressed to the department and user. Other users of the Ticket will not be seen. '
,'USERS_make_create' => 'Create User' 

,'USERS_uid' => 'UID' 
,'USERS_privs' => 'Privilege' 
,'USERS_p_1' => 'Setup. Department '
,'USERS_p_2' => 'Employee' 
,'USERS_p_3' => 'Setup. management '
,'USERS_msg_edit_ok' => 'User data successfully edited!' 
,'USERS_make_edit' => 'Edit user data' 
,'USERS_acc' => 'Account' 
,'USERS_not_active' => 'Off' 
,'USERS_active' => 'Enabled' 
,'USERS_editable' => 'Edit user data' 
,'DEPS_title' => 'Departments' 
,'DEPS_name' => 'Department Name' 
,'DEPS_add' => 'Add' 
,'DEPS_n' => 'Name' 
,'DEPS_action' => 'Action' 
,'APPROVE_title' => 'Confirm the change of information' 
,'APPROVE_info' => 'Information' 
,'APPROVE_fio' => 'Name' 
,'APPROVE_login' => 'Login' 
,'APPROVE_posada' => 'Position' 
,'APPROVE_unit' => 'Category' 
,'APPROVE_tel' => 'Phone' 
,'APPROVE_adr' => 'Address' 
,'APPROVE_mail' => 'E-mail' 
,'APPROVE_app' => 'Confirm?' 
,'APPROVE_orig' => 'Original' 
,'APPROVE_yes' => 'Yes' 
,'APPROVE_no' => 'No' 
,'APPROVE_want' => 'want to change' 


,'POSADA_title' => 'Positions' 
,'POSADA_name' => 'Position Title' 
,'POSADA_add' => 'Add' 
,'POSADA_n' => 'Name' 
,'POSADA_action' => 'Action' 


,'UNITS_title' => 'Control System' 
,'UNITS_name' => 'Name of Control' 
,'UNITS_add' => 'Add' 
,'UNITS_n' => 'Name' 
,'UNITS_action' => 'Action' 


,'SUBJ_title' => 'Topics Tickets' 
,'SUBJ_name' => 'Topic Title' 
,'SUBJ_add' => 'Add' 
,'SUBJ_n' => 'Name' 
,'SUBJ_action' => 'Action' 


,'STATS_TITLE' => 'User statistics' 
,'STATS_in' => 'Incoming ticket' 
,'STATS_out' => 'Outgoing ticket' 
,'STATS_new' => 'New' 
,'STATS_lock' => 'with which to work' 
,'STATS_ok' => 'Achieved me' 
,'STATS_nook' => 'not made​​' 
,'STATS_create' => 'Created by Me' 
,'STATS_lock_o' => 'Work' 
,'STATS_ok_o' => 'Done' 
,'STATS_help1' => '<li> new - requests that are addressed to you or your department and you can meet them. </ li> <li> Blocked - Ticket you are working on. </ li> <li> Fulfilled - requests that you have already completed (after a while go into the archive and disappear on schedule) </ li> '
,'STATS_help2' => '<li> not made ​​- requests that you have created, but no one has yet performed. </ li> <li> Blocked - orders, over which someone works. </ li> <li> Fulfilled - requests that you have created and executed </ li> ' 
,'STATS_in_now' => 'Inbox Ticket now' 
,'STATS_t' => 'Tickets' 
,'STATS_t_ok' => 'Completed' 
,'STATS_t_free' => 'Free' 
,'STATS_out_all' => 'Outgoing Tickets for the entire period' 
,'STATS_t_lock' => 'with which to work', 



'DASHBOARD_def_msg' => ', welcome to the Ticket system </strong> </center> <br> recommend you see <a href=\'help\' class=\'alert-link\'> </i > Directions </a> at work system. <br> <a href=\'create\'class=\'alert-link\'> Or create a new Ticket </a> right now! ',

'msg_creted_new_user' => 'new user will be wound up.'


,'MAIL_active' => 'Account activated' 
,'MAIL_adr' => 'Address' 
,'MAIL_active_u' => 'The user account is activated' 
,'MAIL_cong' => 'Welcome to Ticket System' 
,'MAIL_data' => 'data' 
,'MAIL_name' => 'System Tickets' 
,'MAIL_new' => 'NEW ORDER' 
,'MAIL_code' => 'Request Code' 
,'MAIL_2link' => 'Go to page Ticket' 
,'MAIL_info' => 'Information' 
,'MAIL_created' => 'Ticket created' 
,'MAIL_to' => 'To' 
,'MAIL_prio' => 'Priority' 
,'MAIL_worker' => 'Employee' 
,'MAIL_msg' => 'Message' 
,'MAIL_subj' => 'Subject' 
,'MAIL_text' => 'text' 
,'t_LIST_worker_to' => 'employee' 
,'t_LIST_person' => 'personal' 

,'HELP_title' => 'How to work with the Tickets' 
,'HELP_new' => 'Create Ticket' 
,'HELP_review' => 'View Ticket' 
,'HELP_edit_user' => 'Change the user information' 
,'HELP_new_text' => '<p> To create an Ticket, you must fill out the required fields. 
                                 </ p> 
                                 <ol> 
                                     <li> <strong> From </ strong> - You need to start typing part of the surname, first name or username. If such employee is already in the system, then you will automatically be prompted to select from the list. If it is not - it will be created. In the right part of the page, you can optionally specify the contact details for the person. Typically a contact telephone number, e. </ Li> 
                                     <li> <strong> Who </ strong> - specifies department. Be sure to specify the department, as well as optional receiver. If you specify only the department, then the Ticket will see all employees of the department. If you specify more and performer, then the Ticket will only see receiver and the head of his department. </ Li> 
                                     <li> <strong> Priority </ strong> - specifies the priority of the Ticket. The general list Ticket can be seen by certain marks. </ Li> 
                                     <li> <strong> Subject </ strong> - briefly stated theme of the Ticket. </ li> 
                                     <li> <strong> Message </ strong> - specifies in detail the essence of the Ticket. </ li> 
                                 </ ol> ', 
'HELP_review_text' => '<p> you are three "directory", "Inbox", "Outbox", "archive". Details are below. 
                                 </ p> 
                                 <ul> 
                                     <li> <strong> Inbox </ strong> - This directory contains all Ticket directly targeting you or your department. 
If you are an user - you only see Tickets targeting the entire department or directly to you. (requests addressed to you and the department). 
If you are an head of the department - you can see all your Tickets department (addressed to you, the users, and department). 
                                     </ li> 
                                     <li> <strong> Outgoing </ strong> - This directory contains all the Tickets that you have created. You can view the status of your Tickets created. 
                                     </ li> 
                                     <li> <strong> Archive </ strong> - This directory contains all Tickets that have been made​​, and some time later moved to the archive. They go to the archive automatically. 
                                     </ li> 
                                 </ ul> 
                                 <p> 
                                     The list of Tickets having different colors, in order to see their status. If the Ticket is black color - it will not be read. Blue - expect action. Yellow - blocked you. Gray - blocked by the user. Green - the Ticket is made. 
                                 </ p> 
                                 <center> 
                                 <img src="img/help3.png" class="img-responsive"> 
                                 </ center> 
                                 <p> 
                                     <strong> Once you or your department received a new Ticket </ strong>, you need to see it by clicking on the topic and decide: 
                                 <ul> 
                                     <li> <strong> Diversion to another department / or user </ strong> - If the Ticket is not in your jurisdiction, you can transfer the Ticket to another department or person. 
                                     </ li> 
                                     <li> <strong> Block it </ strong> - for all to see that you are working at this time with the Ticket, and other users can not do anything with the Ticket except the department head. 
                                     <li> <strong> Run it </ strong> - means a request fulfilled and after a while it gets to the archive </ li> 

                                         </ ul> 
                                     </ li> 
                                 </ ul> 
                                 </ p> 
                                 <p> 
                                     Also you can comment on the proposal. 
                                 </ p> ', 
'HELP_edit_user_text' => '<p> Sometimes you need to add information about the user or change it. 
To do this, there is a section - Members. Locate the user that you need and change the data. After that, they will be tested by the system administrator and change. 
                                 </ p> ', 
'SYSTEM_lang'=>'Language',
'summernote_lang'=> 'en-US',
'note_save'=>'Record saved',
'upload_errortypes'=>'File type not allowed',
'upload_errorsize'=>'File is too large',
'file_info'=>'File',
'file_info2'=>'uploaded',
'last_more'=>'more',
'ticket_sort_def'=>'Show all',
'ticket_sort_ok'=>'Success tickets',
'ticket_sort_ilock'=>'Lock by me',
'ticket_sort_lock'=>'Lock not me',
''=>''
);
return isset($lang[$phrase]) ? $lang[$phrase] : 'undefined';
//return $lang[$phrase]; 
} 
?>
