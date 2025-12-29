logfile namer

subscription,
password
logout
login
registration
profile
project
activities
materials
DPR



log_daily(
'subscription',
'subscription request received with data.',
'subscription',
'info',
json_encode($request->all())
);




Inprogress activities : all the activities who DPR is entried + qty less than estimate activiities + acitvites whose DPR is entred & estimate qty in masters not added

Details in completed not loading : all those activities completed qty is equal or more than estimated qty , then those activities can be visible here

Not started: all activities who DPR is not added at all

Delay: based in estimate dates & DPR entry if exceeds end date of this activities in masters , then its delay + acitivities whose end date is exceeded & acitivities not started i.e DPR is not enered+ acitivities whose completed qty is less or than estimate & end is over then its delay
