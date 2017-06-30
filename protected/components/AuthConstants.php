<?php
class AuthConstants
{
	/**
	 * Role that will allow the super page to show like a plugin page
	 * @var string
	 */
	const ROLE_SUPERPLUGIN = 'superplugin';

	const PLUGIN_KEY = 'A';

	const OPT_COMPANY_PLUGIN_MENU = 'OPT_COMPANY_PLUGIN_MENU';

	const POS_END2 = 10;

	const ROLE_ADMIN =     'admin';
	/**
	 * Who can edit project and company data
	 * Not to be confused by wordpress Editor role
	 */
	const ROLE_EDITOR =    'editor';

	/**
	 * Who can access projects, companies, people in readonly mode.
	 */
	const ROLE_DEMO =    'demo';

	const OPT_PROJECT_SAVE =   'OPT_PROJECT_SAVE';
	const OPT_COMPANY_SAVE =   'OPT_COMPANY_SAVE';
	const OPT_SECTOR_SAVE =    'OPT_SECTOR_SAVE';
	const OPT_NO_MODERATION =     'OPT_NO_MODERATION';

	const OPT_COMPANY_SUPER_EDITOR = 'OPT_COMPANY_SUPER_EDITOR';
	const OPT_PROJECT_SUPER_EDITOR = 'OPT_PROJECT_SUPER_EDITOR';
	const OPT_PROJECT_SUPER_PROJECT_LINK = 'OPT_PROJECT_SUPER_PROJECT_LINK';
	const OPT_SEE_SECTOR_FULLVIEW_FEES = 'OPT_SEE_SECTOR_FULLVIEW_FEES';
	const OPT_PROJECT_SUPER_HBAR_LINKED = 'OPT_PROJECT_SUPER_HBAR_LINKED';
	const OPT_ALL_SUPER_DIRECT_PDF_LINE = 'OPT_ALL_SUPER_DIRECT_PDF_LINE';
	const OPT_PROJECT_SUPER_COMPANY_LINK = 'OPT_PROJECT_SUPER_COMPANY_LINK';
	const OPT_PROJECT_SUPER_SUPPLIER_LINK = 'OPT_PROJECT_SUPER_SUPPLIER_LINK';
}
