<?php

/**
 * Notification Center Tokens
 */
foreach ($GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'] as $strType => $arrTypes)
{
    foreach ($arrTypes as $strConcreteType => &$arrType)
    {
        foreach (['email_subject', 'email_text', 'email_html', 'email_sender_name', 'recipients', 'email_recipient_cc', 'email_recipient_bcc',] as $strName)
        {
            if (isset($arrType[$strName]))
            {
                $GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'][$strType][$strConcreteType][$strName] = array_unique(
                    array_merge(
                        [
                            'assignee_emails',
                        ],
                        $GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'][$strType][$strConcreteType][$strName]
                    )
                );
            }
        }
    }
}

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['sendNotificationMessage'][] = ['HeimrichHannot\Assignment\NotificationCenter\Tokens', 'addNotificationCenterTokens'];