#importing important things
from datetime import date
from zang import ZangException, Configuration, ConnectorFactory
from zang.configuration.configuration import Configuration
from zang.connectors.connector_factory import ConnectorFactory

from zang.domain.enums.call_status import CallStatus
from zang.domain.enums.http_method import HttpMethod
from zang.domain.enums.if_machine import IfMachine
from zang.domain.enums.end_call_status import EndCallStatus
from zang.domain.enums.audio_direction import AudioDirection
from zang.domain.enums.recording_file_format import RecordingFileFormat
from zang.domain.enums.recording_audio_direction import RecordingAudioDirection
from zang.domain.enums.transcribe_quality import TranscribeQuality
from zang.exceptions.zang_exception import ZangException


class notify:

	#this is supposed to be a constructor and will set up important variables
	def __init__(self):
		#these will have to be changed for different accounts
		self.sid = 'AC228890845030a255d42643ff8f7bd507'
		self.authToken = 'c8c671c58e454e2ca642851420136f95'

		self.url = 'http://api.zang.io/v2'
		self.configuration = Configuration(self.sid, self.authToken, url=self.url)
		self.smsMessagesConnector = ConnectorFactory(self.configuration).smsMessagesConnector
		self.callsConnector = ConnectorFactory(self.configuration).callsConnector

		#this will have to be changed for different accounts, it's the number the account will use
		self.no='+19892560265'

	#Send a text message:
	#String number is a the number you want to send a text to
	#String text is the text to send
	def sendText(self, number, text):

		try:
		   self.smsMessage = self.smsMessagesConnector.sendSmsMessage(to=number,body=text,from_=self.no)
		   print(self.smsMessage)
		except ZangException as ze:
		    print(ze)

	 #Call a number:
	 #String number is the number to call
	def call(self, number):

		try:
			call = self.callsConnector.makeCall(to=number,
				from_=self.no,

				#This is the XML file that I'm using as a default
				url='http://cloud.zang.io/data/inboundxml/7bb4bd2cc1c2d5a03be3c46f4fda2b48e38e5117',
				method=HttpMethod.GET,

				#This is what the bot will say if it can't find the url for any reason
				fallbackUrl='http://www.zang.io/ivr/welcome/call',
				fallbackMethod=HttpMethod.POST,
				timeout=122,
				hideCallerId=False,)
			print(call.sid)

		except ZangException as ze:
			print(ze)
