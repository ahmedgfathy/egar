{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
-->*}
{strip}
<!DOCTYPE html>
<html>
	<head>
		<title>
			{vtranslate($PAGETITLE, $MODULE_NAME)}
		</title>
		<meta name="format-detection" content="telephone=no">
		<link REL="SHORTCUT ICON" HREF="layouts/vlayout/skins/images/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="libraries/jquery/chosen/chosen.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="libraries/jquery/jquery-ui/css/custom-theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="libraries/jquery/select2/select2.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="libraries/bootstrap/css/bootstrap.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="libraries/bootstrap/css/jqueryBxslider.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="resources/styles.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="libraries/jquery/posabsolute-jQuery-Validation-Engine/css/validationEngine.jquery.css" />
		<link rel="stylesheet" href="libraries/jquery/select2/select2.css" />
		<link rel="stylesheet" href="libraries/guidersjs/guiders-1.2.6.css"/>
		<link rel="stylesheet" href="libraries/jquery/pnotify/jquery.pnotify.default.css"/>
		<link rel="stylesheet" href="libraries/jquery/pnotify/use for pines style icons/jquery.pnotify.default.icons.css"/>
		<link rel="stylesheet" media="screen" type="text/css" href="libraries/jquery/datepicker/css/datepicker.css" />
		
				<link rel="shortcut icon" href="favicon.ico" />
		

		



			
			/* Modern Buttons with Curves */
			.btn {
				border-radius: 8px !important;
				font-weight: 500 !important;
				transition: all 0.2s ease !important;
				box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
			}
			
			.btn:hover {
				transform: translateY(-1px) !important;
				box-shadow: 0 4px 15px rgba(0,0,0,0.15) !important;
			}
			
			.btn-primary { 
				background: linear-gradient(135deg, #3498DB, #2980B9) !important;
				border-color: #2980B9 !important;
				color: white !important;
			}
			
			.btn-success { 
				background: linear-gradient(135deg, #27AE60, #229954) !important;
				border-color: #229954 !important;
			}
			
			/* Professional Headers */
			h1, h2, h3, h4, h5, h6 { 
				color: #2C3E50 !important;
				font-weight: 600 !important;
				letter-spacing: -0.02em !important;
			}
			
			/* Modern Form Inputs */
			input[type="text"], input[type="email"], input[type="password"], 
			input[type="number"], select, textarea {
				border-radius: 8px !important;
				border: 1px solid #DEE2E6 !important;
				transition: all 0.2s ease !important;
				box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
			}
			
			input:focus, select:focus, textarea:focus {
				border-color: #3498DB !important;
				box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1) !important;
				outline: none !important;
			}
			
			/* Modern Table Headers */
			.table th, .listview-table th {
				background: linear-gradient(135deg, #F8F9FA, #E9ECEF) !important;
				color: #2C3E50 !important;
				font-weight: 600 !important;
			}
			
			/* Widget Headers with Subtle Shadow */
			.widget_header {
				background: linear-gradient(135deg, #FFFFFF, #F8F9FA) !important;
				border-radius: 8px 8px 0 0 !important;
				box-shadow: 0 1px 5px rgba(0,0,0,0.05) !important;
				font-weight: 600 !important;
				color: #2C3E50 !important;
			}
			
			/* Modern Alert Messages */
			.alert {
				border-radius: 10px !important;
				box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important;
				border: none !important;
			}
			
			/* Professional Footer - Enhanced */
			.navbar-fixed-bottom .navbar-inner {
				background: linear-gradient(135deg, #2C3E50, #34495E) !important;
				border-radius: 12px 12px 0 0 !important;
				box-shadow: 0 -2px 15px rgba(44, 62, 80, 0.1) !important;
				padding: 15px 0 !important;
			}
			
			/* Enhanced Footer Typography */
			.footer-content {
				text-align: center !important;
				font-family: 'Inter', 'Segoe UI', system-ui, sans-serif !important;
			}
			
			.footer-content a {
				color: #ECF0F1 !important;
				font-weight: 700 !important;
				font-size: 16px !important;
				text-decoration: none !important;
				letter-spacing: 0.5px !important;
				text-transform: uppercase !important;
				transition: all 0.3s ease !important;
			}
			
			.footer-content a:hover {
				color: #3498DB !important;
				text-shadow: 0 2px 8px rgba(52, 152, 219, 0.3) !important;
			}
			
			.footer-content small {
				color: #BDC3C7 !important;
				font-size: 13px !important;
				font-weight: 500 !important;
				letter-spacing: 0.3px !important;
			}
			
			/* Dashboard Widgets - Modern Styling */
			.dashBoardWidgetContainer,
			.widgetContainer {
				background: white !important;
				border-radius: 12px !important;
				box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
				border: 1px solid #F1F3F4 !important;
				margin-bottom: 20px !important;
				overflow: hidden !important;
				transition: all 0.3s ease !important;
			}
			
			.dashBoardWidgetContainer:hover,
			.widgetContainer:hover {
				transform: translateY(-2px) !important;
				box-shadow: 0 8px 30px rgba(0,0,0,0.12) !important;
			}
			
			/* Dashboard Header */
			.dashboardHeading {
				background: linear-gradient(135deg, #FFFFFF, #F8F9FA) !important;
				border-radius: 12px !important;
				box-shadow: 0 3px 15px rgba(0,0,0,0.08) !important;
				margin-bottom: 20px !important;
				padding: 20px !important;
				border: 1px solid #E9ECEF !important;
			}
			
			.dashboardHeading h2 {
				color: #2C3E50 !important;
				font-weight: 600 !important;
				font-size: 24px !important;
				margin: 0 !important;
				letter-spacing: -0.02em !important;
			}
			
			/* Left Sidebar Modern Styling */
			.sidebar, .sidebarDiv {
				background: white !important;
				border-radius: 12px !important;
				box-shadow: 0 2px 12px rgba(0,0,0,0.06) !important;
				border: 1px solid #F1F3F4 !important;
			}
			
			.sidebar .nav li a {
				padding: 12px 18px !important;
				color: #2C3E50 !important;
				font-weight: 500 !important;
				border-radius: 6px !important;
				margin: 2px 8px !important;
				transition: all 0.2s ease !important;
			}
			
			.sidebar .nav li a:hover {
				background: linear-gradient(135deg, #F8F9FA, #E9ECEF) !important;
				color: #3498DB !important;
				transform: translateX(3px) !important;
			}
			
			.sidebar .nav li.active a {
				background: linear-gradient(135deg, #3498DB, #2980B9) !important;
				color: white !important;
			}
			
			/* ===== ENHANCED LIST VIEW & TABLES DESIGN ===== */
			
			/* List View Page Container */
			.listViewPageDiv {
				background: white !important;
				border-radius: 12px !important;
				box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
				border: 1px solid #E9ECEF !important;
				margin: 15px !important;
				overflow: visible !important;
			}
			
			/* List View Top Menu */
			.listViewTopMenuDiv {
				background: linear-gradient(135deg, #F8F9FA, #FFFFFF) !important;
				border-bottom: 1px solid #E9ECEF !important;
				padding: 20px !important;
				border-radius: 12px 12px 0 0 !important;
			}
			
			/* Fix for List View Content */
			.listViewContentDiv {
				padding: 0 !important;
				background: white !important;
				min-height: auto !important;
				overflow: visible !important;
			}
			
			/* Ensure table is visible */
			.listViewEntriesDiv {
				background: white !important;
				padding: 0 !important;
				overflow: visible !important;
			}
			
			/* Modern Action Buttons */
			.listViewActionsDiv .btn {
				border-radius: 8px !important;
				font-weight: 600 !important;
				padding: 12px 20px !important;
				font-size: 14px !important;
				letter-spacing: 0.02em !important;
				transition: all 0.2s ease !important;
				box-shadow: 0 3px 12px rgba(0,0,0,0.1) !important;
				border: none !important;
			}
			
			/* Primary Action Button (Add Property, etc.) */
			.addButton, .btn-primary {
				background: linear-gradient(135deg, #3498DB, #2980B9) !important;
				color: white !important;
			}
			
			/* Actions Container - Reduce Height */
			.module-action-bar, .listview-actions-container,
			.widget_header, .listViewActionsDiv {
				background: linear-gradient(135deg, #ECF0F1 0%, #D5DBDB 100%) !important;
				border: 1px solid #BDC3C7 !important;
				border-radius: 8px !important;
				margin: 8px 0 !important;
				padding: 8px 16px !important;
				box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
				min-height: 50px !important;
				max-height: 60px !important;
				height: auto !important;
				display: flex !important;
				align-items: center !important;
				justify-content: space-between !important;
			}
			
			/* Safe Second Header - Minimal Styling */
			.listViewTopMenuDiv {
				background: #F8F9FA !important;
				padding: 10px !important;
				border-radius: 6px !important;
				margin: 5px 0 !important;
			}
			
			/* Enhanced listViewTopMenuDiv noprint styling */
			.listViewTopMenuDiv.noprint {
				background: linear-gradient(135deg, #ECF0F1 0%, #D5DBDB 100%) !important;
				border: 1px solid #BDC3C7 !important;
				border-radius: 8px !important;
				padding: 12px 16px !important;
				margin: 8px 0 !important;
				box-shadow: 0 2px 6px rgba(0,0,0,0.08) !important;
				position: relative !important;
			}
			
			.listViewTopMenuDiv.noprint:before {
				content: "" !important;
				position: absolute !important;
				top: 0 !important;
				left: 0 !important;
				right: 0 !important;
				height: 2px !important;
				background: linear-gradient(90deg, #3498DB 0%, #2980B9 50%, #3498DB 100%) !important;
				border-radius: 8px 8px 0 0 !important;
			}
			
			/* Content within noprint div */
			.listViewTopMenuDiv.noprint * {
				position: relative !important;
				z-index: 1 !important;
			}
			
			/* Simple Search Box Styling */
			input[type="text"], .search-input {
				padding: 8px !important;
				border: 1px solid #BDC3C7 !important;
				border-radius: 4px !important;
				font-size: 14px !important;
			}
			
			/* Fix overlapping elements */
			.contentHeader, .listview-content-header {
				position: relative !important;
				z-index: 5 !important;
				background: white !important;
				padding: 12px !important;
				border-bottom: 1px solid #E9ECEF !important;
			}
			
			/* Basic Container Styling - Non-Interfering */
			.listViewPageDiv, .listViewContentDiv {
				background: transparent !important;
				padding: 15px !important;
			}
			
			.addButton:hover, .btn-primary:hover {
				background: linear-gradient(135deg, #2980B9, #1F618D) !important;
				transform: translateY(-2px) !important;
				box-shadow: 0 6px 20px rgba(52, 152, 219, 0.3) !important;
			}
			
			/* Actions Dropdown */
			.dropdown-toggle {
				background: linear-gradient(135deg, #34495E, #2C3E50) !important;
				color: white !important;
			}
			
			.dropdown-toggle:hover {
				background: linear-gradient(135deg, #2C3E50, #1B2631) !important;
			}
			
			/* Dropdown Menu */
			.dropdown-menu {
				border-radius: 10px !important;
				box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
				border: 1px solid #E9ECEF !important;
				padding: 10px 0 !important;
			}
			
			.dropdown-menu li a {
				padding: 12px 20px !important;
				font-weight: 500 !important;
				color: #2C3E50 !important;
				transition: all 0.2s ease !important;
			}
			
			.dropdown-menu li a:hover {
				background: linear-gradient(135deg, #F8F9FA, #E9ECEF) !important;
				color: #3498DB !important;
			}
			
			/* Filter Dropdown */
			.select2-container .select2-choice {
				background: linear-gradient(135deg, #FFFFFF, #F8F9FA) !important;
				border: 1px solid #DEE2E6 !important;
				border-radius: 8px !important;
				height: 42px !important;
				line-height: 40px !important;
				font-weight: 500 !important;
				color: #2C3E50 !important;
				box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
			}
			
			.select2-container .select2-choice:hover {
				border-color: #3498DB !important;
				box-shadow: 0 4px 15px rgba(52, 152, 219, 0.1) !important;
			}
			
			/* Enhanced Table Design - Fixed Visibility */
			.listViewEntriesTable, .table {
				border-radius: 0 !important;
				border: none !important;
				font-family: 'Inter', 'Segoe UI', system-ui, sans-serif !important;
				font-size: 14px !important;
				background: white !important;
				width: 100% !important;
				border-collapse: separate !important;
				border-spacing: 0 !important;
				display: table !important;
				visibility: visible !important;
				opacity: 1 !important;
			}
			
			/* Bottom Scroll Container */
			.contents-bottomscroll {
				background: white !important;
				padding: 0 15px 15px 15px !important;
			}
			
			.bottomscroll-div {
				background: white !important;
			}
			
			/* Table Headers - Premium Design */
			.listViewEntriesTable thead th, .table thead th {
				background: linear-gradient(135deg, #2C3E50, #34495E) !important;
				color: white !important;
				font-weight: 600 !important;
				font-size: 12px !important;
				text-transform: uppercase !important;
				letter-spacing: 0.8px !important;
				padding: 20px 12px !important;
				border: none !important;
				position: relative !important;
				text-shadow: 0 1px 2px rgba(0,0,0,0.2) !important;
				vertical-align: middle !important;
				text-align: center !important;
			}
			
			.listViewEntriesTable thead th:first-child {
				border-radius: 0 !important;
				text-align: left !important;
				width: 50px !important;
			}
			
			.listViewEntriesTable thead th:last-child {
				border-radius: 0 !important;
			}
			
			/* Table Header Links */
			.listViewHeaderValues {
				color: white !important;
				text-decoration: none !important;
				font-weight: 600 !important;
				display: block !important;
				padding: 5px 0 !important;
			}
			
			.listViewHeaderValues:hover {
				color: #3498DB !important;
				text-shadow: 0 2px 4px rgba(52, 152, 219, 0.3) !important;
			}
			
			/* Table Rows - Modern Design */
			.listViewEntriesTable tbody tr {
				transition: all 0.2s ease !important;
				border-bottom: 1px solid #F1F3F4 !important;
				background: white !important;
			}
			
			.listViewEntriesTable tbody tr:hover {
				background: linear-gradient(135deg, #F8F9FA, #FFFFFF) !important;
				box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
				transform: translateY(-1px) !important;
			}
			
			.listViewEntriesTable tbody tr:nth-child(even) {
				background: #FAFBFC !important;
			}
			
			.listViewEntriesTable tbody tr:nth-child(even):hover {
				background: linear-gradient(135deg, #F8F9FA, #FFFFFF) !important;
			}
			
			/* Table Cells */
			.listViewEntriesTable td {
				padding: 18px 12px !important;
				border-top: none !important;
				vertical-align: middle !important;
				font-weight: 500 !important;
				color: #2C3E50 !important;
				border-left: 1px solid transparent !important;
				border-right: 1px solid transparent !important;
				text-align: center !important;
			}
			
			.listViewEntriesTable td:first-child {
				text-align: left !important;
				width: 50px !important;
			}
			
			/* Property Links */
			.listViewEntryValue a {
				color: #3498DB !important;
				font-weight: 600 !important;
				text-decoration: none !important;
				transition: all 0.2s ease !important;
				padding: 8px 12px !important;
				border-radius: 6px !important;
				display: inline-block !important;
			}
			
			.listViewEntryValue a:hover {
				color: white !important;
				background: #3498DB !important;
				box-shadow: 0 3px 8px rgba(52, 152, 219, 0.3) !important;
				transform: translateY(-1px) !important;
			}
			
			/* Status and Type Cells */
			.listViewEntryValue[data-field-type="picklist"] {
				font-weight: 600 !important;
				text-transform: uppercase !important;
				font-size: 12px !important;
				letter-spacing: 0.5px !important;
			}
			
			/* Status Badges */
			.listViewEntriesTable td:contains("REIDENTIAL") {
				background: linear-gradient(135deg, #E8F5E8, #D5EDDA) !important;
				color: #27AE60 !important;
				border-radius: 4px !important;
				font-weight: 600 !important;
			}
			
			/* Date Formatting */
			.listViewEntryValue[data-field-type="date"] {
				font-family: 'Monaco', 'Consolas', monospace !important;
				font-weight: 500 !important;
				color: #7F8C8D !important;
				font-size: 13px !important;
			}
			
			/* Alphabet Navigation */
			.alphabetSorting .table {
				background: linear-gradient(135deg, #F8F9FA, #E9ECEF) !important;
				border-radius: 8px !important;
				overflow: hidden !important;
				margin: 15px 0 !important;
				box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
			}
			
			.alphabetSearch a {
				color: #2C3E50 !important;
				font-weight: 600 !important;
				font-size: 14px !important;
				transition: all 0.2s ease !important;
				display: block !important;
				padding: 12px !important;
			}
			
			.alphabetSearch a:hover {
				background: #3498DB !important;
				color: white !important;
				transform: scale(1.1) !important;
			}
			
			/* Search Row */
			.listViewEntriesTable tbody tr:first-child {
				background: linear-gradient(135deg, #E8F4FD, #FFFFFF) !important;
			}
			
			.listViewEntriesTable tbody tr:first-child td {
				border-bottom: 2px solid #3498DB !important;
			}
			
			.listSearchContributor {
				border: 1px solid #DEE2E6 !important;
				border-radius: 6px !important;
				padding: 8px 12px !important;
				font-size: 13px !important;
				transition: all 0.2s ease !important;
			}
			
			.listSearchContributor:focus {
				border-color: #3498DB !important;
				box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.1) !important;
				outline: none !important;
			}
			
			/* Search Button */
			.listViewEntriesTable button[data-trigger="listSearch"] {
				background: linear-gradient(135deg, #27AE60, #229954) !important;
				color: white !important;
				border: none !important;
				border-radius: 6px !important;
				padding: 8px 16px !important;
				font-weight: 600 !important;
				transition: all 0.2s ease !important;
			}
			
			.listViewEntriesTable button[data-trigger="listSearch"]:hover {
				background: linear-gradient(135deg, #229954, #1E8449) !important;
				transform: translateY(-1px) !important;
				box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3) !important;
			}
			
			/* Action Icons */
			.actionImages i {
				color: #7F8C8D !important;
				font-size: 18px !important;
				margin: 0 5px !important;
				transition: all 0.2s ease !important;
				padding: 8px !important;
				border-radius: 50% !important;
				background: rgba(127, 140, 141, 0.1) !important;
			}
			
			.actionImages i:hover {
				color: white !important;
				background: #3498DB !important;
				transform: scale(1.2) !important;
				box-shadow: 0 3px 8px rgba(52, 152, 219, 0.3) !important;
			}
			
			.actionImages .icon-trash:hover {
				background: #E74C3C !important;
				box-shadow: 0 3px 8px rgba(231, 76, 60, 0.3) !important;
			}
			
			.actionImages .icon-pencil:hover {
				background: #F39C12 !important;
				box-shadow: 0 3px 8px rgba(243, 156, 18, 0.3) !important;
			}
			
			.actionImages .icon-th-list:hover {
				background: #9B59B6 !important;
				box-shadow: 0 3px 8px rgba(155, 89, 182, 0.3) !important;
			}
			
			/* Better Cell Spacing and Alignment */
			.listViewEntriesTable td.wide {
				min-width: 120px !important;
				max-width: 200px !important;
				word-wrap: break-word !important;
				white-space: nowrap !important;
				overflow: hidden !important;
				text-overflow: ellipsis !important;
			}
			
			/* Property Number Column */
			.listViewEntriesTable td:nth-child(2) {
				font-family: 'Monaco', 'Consolas', monospace !important;
				font-weight: 600 !important;
				color: #8E44AD !important;
			}
			
			/* Actions Column */
			.listViewEntriesTable td:last-child {
				width: 120px !important;
				text-align: center !important;
			}
			
			/* Search Row Enhancement */
			.listViewEntriesTable tbody tr:first-child {
				background: linear-gradient(135deg, #EBF3FD, #D6EAF8) !important;
				border-bottom: 2px solid #3498DB !important;
			}
			
			.listViewEntriesTable tbody tr:first-child:hover {
				background: linear-gradient(135deg, #EBF3FD, #D6EAF8) !important;
				transform: none !important;
				box-shadow: none !important;
			}
			
			/* Mobile Responsive */
			@media (max-width: 768px) {
				.listViewEntriesTable td {
					padding: 12px 8px !important;
					font-size: 12px !important;
				}
				
				.listViewEntriesTable thead th {
					padding: 15px 8px !important;
					font-size: 11px !important;
				}
			}
			
			/* Pagination - Enhanced Design */
			.listViewActions {
				padding: 20px !important;
				background: linear-gradient(135deg, #F8F9FA, #FFFFFF) !important;
				border-top: 1px solid #E9ECEF !important;
				border-radius: 0 0 12px 12px !important;
			}
			
			/* Pagination Buttons */
			.listViewActions .btn {
				background: white !important;
				border: 1px solid #DEE2E6 !important;
				color: #2C3E50 !important;
				border-radius: 8px !important;
				padding: 10px 15px !important;
				font-weight: 500 !important;
				transition: all 0.2s ease !important;
				margin: 0 2px !important;
			}
			
			.listViewActions .btn:hover {
				background: #3498DB !important;
				border-color: #3498DB !important;
				color: white !important;
				transform: translateY(-1px) !important;
				box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2) !important;
			}
			
			.listViewActions .btn:disabled {
				background: #F8F9FA !important;
				color: #BDC3C7 !important;
				border-color: #E9ECEF !important;
				cursor: not-allowed !important;
			}
			
			/* Page Numbers Text */
			.pageNumbersText {
				font-weight: 600 !important;
				color: #2C3E50 !important;
				margin: 0 15px !important;
			}
			
			/* Settings Icon */
			.settingsIcon .btn {
				background: linear-gradient(135deg, #95A5A6, #7F8C8D) !important;
				color: white !important;
				border: none !important;
			}
			
			.settingsIcon .btn:hover {
				background: linear-gradient(135deg, #7F8C8D, #6C7B7F) !important;
			}
			
			/* Checkboxes */
			input[type="checkbox"] {
				width: 18px !important;
				height: 18px !important;
				accent-color: #3498DB !important;
			}
			
			/* Content Container Padding */
			.listViewContentDiv {
				padding: 0 !important;
			}
			
			/* Right Panel Fixes */
			.contentsDiv {
				min-height: auto !important;
				overflow: visible !important;
			}
			
			#rightPanel {
				min-height: auto !important;
			}
			
			/* Ensure main container doesn't hide content */
			.span10.marginLeftZero {
				min-height: auto !important;
			}
			
			/* Module Title */
			.module-action-bar h3, .listview-header h3 {
				color: #2C3E50 !important;
				font-weight: 700 !important;
				font-size: 24px !important;
				margin: 0 !important;
				text-transform: uppercase !important;
				letter-spacing: 1px !important;
			}
			
			/* Basic Container Styling - Non-Interfering */
			.listViewPageDiv, .listViewContentDiv {
				background: transparent !important;
				padding: 15px !important;
			}
			
			/* Force table to display */
			.listViewEntriesTable, .table.table-bordered {
				display: table !important;
				visibility: visible !important;
				opacity: 1 !important;
				width: 100% !important;
				height: auto !important;
				min-height: auto !important;
				background-color: white !important;
				border-collapse: separate !important;
				border-spacing: 0 !important;
			}
			
			/* Simple Table Headers - Minimal Safe Styling */
			.listViewEntriesTable thead th {
				background: #34495E !important;
				color: white !important;
				padding: 12px 8px !important;
				text-align: center !important;
				font-weight: 600 !important;
				border-bottom: 2px solid #3498DB !important;
			}
			
			/* Clean Table Reset */
			.listViewEntriesTable {
				width: 100% !important;
				border-collapse: collapse !important;
				background: white !important;
				margin: 10px 0 !important;
				box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
				border-radius: 8px !important;
				overflow: hidden !important;
			}
			
			/* Table Body */
			.listViewEntriesTable tbody {
				background: white !important;
			}
			
			.listViewEntriesTable tbody tr {
				border-bottom: 1px solid #E9ECEF !important;
				transition: background-color 0.3s ease !important;
			}
			
			.listViewEntriesTable tbody tr:hover {
				background-color: #F8F9FA !important;
			}
			
			.listViewEntriesTable tbody td {
				padding: 12px !important;
				text-align: center !important;
				border-right: 1px solid #E9ECEF !important;
				font-size: 13px !important;
				color: #2C3E50 !important;
				vertical-align: middle !important;
			}
			
			.listViewEntriesTable tbody td:last-child {
				border-right: none !important;
			}
			
			/* Simple Left Sidebar Styling */
			.sidebar, .leftPanel, .span2 {
				background: #F8F9FA !important;
				border: 1px solid #DEE2E6 !important;
				border-radius: 8px !important;
				padding: 12px !important;
				margin: 8px !important;
				transition: all 0.3s ease !important;
				position: relative !important;
			}
			
			/* Sidebar Toggle Behavior Fix */
			#leftPanel {
				position: fixed !important;
				top: 80px !important;
				left: -250px !important;
				width: 250px !important;
				height: calc(100vh - 100px) !important;
				z-index: 1000 !important;
				transition: left 0.3s ease !important;
				overflow-y: auto !important;
			}
			
			#leftPanel.open {
				left: 0 !important;
			}
			
			/* Prevent content displacement when sidebar opens */
			#rightPanel, .mainContainer {
				transition: margin-left 0.3s ease !important;
				margin-left: 0 !important;
			}
			
			/* Shift main content left when sidebar is hidden */
			.bodyContents {
				margin-left: -20px !important;
				transition: margin-left 0.3s ease !important;
				padding-left: 20px !important;
			}
			
			.containerFluid, .container-fluid {
				margin-left: -15px !important;
				padding-left: 15px !important;
			}
			
			/* Main content area optimization */
			#rightPanel {
				margin-left: -25px !important;
				padding-left: 25px !important;
				width: calc(100% + 25px) !important;
			}
			
			/* When sidebar is open, reset content position */
			.sidebar-open #rightPanel,
			.sidebar-open .bodyContents,
			.sidebar-open .containerFluid {
				margin-left: 0 !important;
			}
			
			/* Toggle button styling */
			#toggleButton {
				position: fixed !important;
				top: 50px !important;
				left: 10px !important;
				z-index: 1001 !important;
				background: #3498DB !important;
				color: white !important;
				border: none !important;
				padding: 8px 12px !important;
				border-radius: 4px !important;
				cursor: pointer !important;
				transition: all 0.3s ease !important;
			}
			
			#toggleButton:hover {
				background: #2980B9 !important;
				transform: scale(1.05) !important;
			}
			
			/* Sidebar Headers */
			.sidebar h3, .leftPanel h3, .sidebar .widgetHeader {
				background: linear-gradient(135deg, #2C3E50 0%, #34495E 100%) !important;
				color: white !important;
				padding: 12px 16px !important;
				margin: -16px -16px 16px -16px !important;
				border-radius: 12px 12px 0 0 !important;
				font-size: 16px !important;
				font-weight: 700 !important;
				text-transform: uppercase !important;
				letter-spacing: 1px !important;
				text-align: center !important;
				box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
			}
			
			/* Sidebar Menu Items */
			.sidebar ul, .leftPanel ul, .sidebar .menuList {
				list-style: none !important;
				padding: 0 !important;
				margin: 0 !important;
			}
			
			.sidebar li, .leftPanel li, .sidebar .menuItem {
				background: white !important;
				border: 1px solid #E9ECEF !important;
				border-radius: 8px !important;
				margin: 8px 0 !important;
				transition: all 0.3s ease !important;
				box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
			}
			
			.sidebar li:hover, .leftPanel li:hover, .sidebar .menuItem:hover {
				background: linear-gradient(135deg, #3498DB 0%, #2980B9 100%) !important;
				color: white !important;
				transform: translateY(-2px) !important;
				box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3) !important;
			}
			
			.sidebar a, .leftPanel a, .sidebar .menuLink {
				display: block !important;
				padding: 12px 16px !important;
				color: #2C3E50 !important;
				text-decoration: none !important;
				font-weight: 600 !important;
				font-size: 14px !important;
				border-radius: 8px !important;
				transition: all 0.3s ease !important;
			}
			
			.sidebar a:hover, .leftPanel a:hover, .sidebar .menuLink:hover {
				color: white !important;
				text-decoration: none !important;
			}
			
			/* Recently Modified Section */
			.recentlyModified, .recent-items {
				background: white !important;
				border: 1px solid #E9ECEF !important;
				border-radius: 8px !important;
				padding: 12px !important;
				margin-top: 16px !important;
			}
			
			/* MCP-based UI Reorganization */
			/* Actions Container with Row-Fluid Layout */
			.actionsContainer {
				background: linear-gradient(135deg, #F8F9FA 0%, #E9ECEF 100%) !important;
				border: 1px solid #DEE2E6 !important;
				border-radius: 8px !important;
				padding: 12px 16px !important;
				margin: 8px 0 !important;
				min-height: 60px !important;
			}
			
			.actionsContainer .row-fluid.clearfix {
				display: flex !important;
				align-items: center !important;
				justify-content: space-between !important;
				width: 100% !important;
				margin: 0 !important;
			}
			
			/* Navigation and Quick Actions Organization */
			.nav.quickActions.btn-toolbar.span2.pull-right.marginLeftZero {
				background: linear-gradient(135deg, #3498DB 0%, #2980B9 100%) !important;
				border: 1px solid #2471A3 !important;
				border-radius: 6px !important;
				padding: 8px 12px !important;
				margin: 0 8px 0 0 !important;
				display: flex !important;
				align-items: center !important;
				gap: 8px !important;
				box-shadow: 0 2px 4px rgba(52, 152, 219, 0.2) !important;
			}
			
			/* Global Search Value Container */
			#globalSearchValue {
				background: white !important;
				border: 1px solid #BDC3C7 !important;
				border-radius: 4px !important;
				padding: 8px 12px !important;
				font-size: 14px !important;
				width: 250px !important;
				transition: all 0.3s ease !important;
			}
			
			#globalSearchValue:focus {
				border-color: #3498DB !important;
				box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2) !important;
				outline: none !important;
			}
			
			/* Chosen Elements Organization */
			.chzn-single.chzn-single-with-drop {
				background: linear-gradient(135deg, #ECF0F1 0%, #D5DBDB 100%) !important;
				border: 1px solid #BDC3C7 !important;
				border-radius: 4px 0 0 4px !important;
				padding: 8px 12px !important;
				color: #2C3E50 !important;
				font-weight: 500 !important;
				transition: all 0.3s ease !important;
			}
			
			.chzn-single.chzn-single-with-drop:hover {
				background: linear-gradient(135deg, #D5DBDB 0%, #BDC3C7 100%) !important;
				border-color: #85929E !important;
			}
			
			/* Span2 and MarginLeftZero Organization */
			.span2.pull-right.marginLeftZero,
			.span2.marginLeftZero {
				width: auto !important;
				margin-left: 0 !important;
				float: right !important;
				display: flex !important;
				align-items: center !important;
				gap: 12px !important;
			}
			
			/* Button Toolbar Enhancement */
			.btn-toolbar {
				background: rgba(255, 255, 255, 0.9) !important;
				border-radius: 6px !important;
				padding: 6px 12px !important;
				box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
				display: flex !important;
				align-items: center !important;
				gap: 8px !important;
			}
			
			/* Container Integration */
			.actionsContainer .span2,
			.actionsContainer .span10 {
				display: flex !important;
				align-items: center !important;
				height: auto !important;
				padding: 0 !important;
			}
			
			.actionsContainer .span10 {
				flex: 1 !important;
				justify-content: flex-start !important;
			}
			
			.actionsContainer .span2 {
				justify-content: flex-end !important;
				width: auto !important;
				min-width: 200px !important;
			}
			
			/* Row-Fluid Clearfix Layout Enhancement */
			.row-fluid.clearfix {
				display: flex !important;
				flex-wrap: wrap !important;
				align-items: center !important;
				width: 100% !important;
				margin: 0 !important;
				padding: 0 !important;
			}
			
			.row-fluid.clearfix:before,
			.row-fluid.clearfix:after {
				content: "" !important;
				display: table !important;
			}
			
			.row-fluid.clearfix:after {
				clear: both !important;
			}
			
			/* Search Element Integration */
			.searchElement {
				display: flex !important;
				align-items: center !important;
				gap: 8px !important;
				flex: 1 !important;
				max-width: 600px !important;
				margin-right: 16px !important;
			}
			
			.searchElement .select-search,
			.searchElement .searchBar {
				display: flex !important;
				align-items: center !important;
			}
			
			/* Final Container Organization */
			.commonActionsContainer .actionsContainer > .span10 > .row-fluid {
				margin-top: 0 !important;
				display: flex !important;
				align-items: center !important;
				justify-content: space-between !important;
				width: 100% !important;
			}
			
			/* Content Width Optimization */
			.listViewPageDiv {
				margin-left: -15px !important;
				padding-left: 30px !important;
				width: calc(100% + 15px) !important;
				box-sizing: border-box !important;
			}
			
			.listViewContentDiv {
				margin-left: -10px !important;
				padding-left: 25px !important;
			}
			
			/* Actions container width optimization */
			.actionsContainer {
				margin-left: -20px !important;
				padding-left: 35px !important;
				width: calc(100% + 20px) !important;
				box-sizing: border-box !important;
			}
		</style>
		
		{foreach key=index item=cssModel from=$STYLES}
                    <link rel="{$cssModel->getRel()}" href="{vresource_url($cssModel->getHref())}" type="{$cssModel->getType()}" media="{$cssModel->getMedia()}" />
		{/foreach}
		
		{* For making pages - print friendly *}
	

		{* This is needed as in some of the tpl we are using jQuery.ready *}
		{* ends *}
		
		<script type="text/javascript" src="libraries/jquery/jquery.min.js"></script>
		<!--[if IE]>
		<script type="text/javascript" src="libraries/html5shim/html5.js"></script>
		<script type="text/javascript" src="libraries/html5shim/respond.js"></script>
		<![endif]-->
		{* ends *}
		{* ADD <script> INCLUDES in JSResources.tpl - for better performance *}	</head>
	<body data-skinpath="{$SKIN_PATH}" data-language="{$LANGUAGE}">
		<div id="js_strings" class="hide noprint">{Zend_Json::encode($LANGUAGE_STRINGS)}</div>
		{assign var=CURRENT_USER_MODEL value=Users_Record_Model::getCurrentUserModel()}
		<input type="hidden" id="start_day" value="{$CURRENT_USER_MODEL->get('dayoftheweek')}" />
		<input type="hidden" id="row_type" value="{$CURRENT_USER_MODEL->get('rowheight')}" />
		<input type="hidden" id="current_user_id" value="{$CURRENT_USER_MODEL->get('id')}" />
		<div id="page">
			<!-- container which holds data temporarly for pjax calls -->
			<div id="pjaxContainer" class="hide noprint"></div>
			
{/strip}
