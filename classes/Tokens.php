<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Assignment\NotificationCenter;

use HeimrichHannot\Assignment\AssigneeModel;
use HeimrichHannot\Assignment\Assignment;
use HeimrichHannot\Assignment\AssignmentDataModel;
use HeimrichHannot\Assignment\AssignmentModel;
use HeimrichHannot\Assignment\Util\Assignee;
use NotificationCenter\Util\String;

class Tokens extends \Controller
{
    protected $objMessage;

    protected $arrTokens;

    protected $strLanguage;

    protected $objGatewayModel;

    public function addNotificationCenterTokens($objMessage, &$arrTokens, $strLanguage, $objGatewayModel)
    {
        $this->objMessage      = $objMessage;
        $this->arrTokens       = $arrTokens;
        $this->strLanguage     = $strLanguage;
        $this->objGatewayModel = $objGatewayModel;

        if ($objMessage->addAssignment)
        {
            $this->addAssigneeEmailTokens();
        }

        $arrTokens = $this->arrTokens;

        return true;
    }

    /**
     * Add assignee email tokens
     */
    protected function addAssigneeEmailTokens()
    {
        $arrEmails         = $this->getAssigneeEmails();
        $arrFallbackEmails = \StringUtil::compileRecipients($this->objMessage->assignmentFallbackEmails, $this->arrTokens);

        // add default emails
        if (empty($arrEmails) || $this->objMessage->assignmentFallbackForce)
        {
            $arrEmails = array_merge($arrEmails, $arrFallbackEmails);
        }

        $arrEmails = array_unique(array_filter($arrEmails));

        foreach ($arrEmails as $key => $email)
        {
            $this->arrTokens['assignee_email_' . $key] = $email;
        }

        $this->arrTokens['assignee_emails'] = implode(',', $arrEmails);
    }

    /**
     * Get all assignee emails as array
     *
     * @return array
     */
    protected function getAssigneeEmails()
    {
        $arrEmails = [];

        $objAssignment = AssignmentModel::findByPk($this->objMessage->assignmentArchive);

        if ($objAssignment === null)
        {
            return null;
        }

        $arrColumns = [];
        $arrValues  = [];
        $arrMapping = deserialize($this->objMessage->assignmentMapping);

        foreach ($arrMapping as $condition)
        {
            if (empty($condition['value']) || empty($condition['field']))
            {
                continue;
            }

            $field = \StringUtil::decodeEntities($condition['field']);
            $value = \Haste\Util\StringUtil::recursiveReplaceTokensAndTags($condition['value'], $this->arrTokens);

            $arrColumns[] = "tl_assignment_data.$field = ?";
            $arrValues[]  = $value;
        }

        if (empty($arrColumns) || empty($arrValues))
        {
            return $arrEmails;
        }

        $objData = AssignmentDataModel::findPublishedBy($arrColumns, $arrValues);

        if ($objData === null)
        {
            return $arrEmails;
        }

        $objAssignees = AssigneeModel::findPublishedByPids($objData->fetchEach('id'));

        if ($objAssignees === null)
        {
            return $arrEmails;
        }

        while ($objAssignees->next())
        {
            if (($strEmail = Assignee::getAssigneeEmail($objAssignees->current())) === null)
            {
                continue;
            }

            $arrEmails[] = $strEmail;
        }

        $arrEmails = array_unique(array_filter($arrEmails));

        if (empty($arrEmails))
        {
            return $arrEmails;
        }

        return $arrEmails;
    }
}
