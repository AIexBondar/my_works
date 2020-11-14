from django.urls import path

from .views import ChatInit

app_name = 'frontend'

urlpatterns = [
	path('', ChatInit, name="chat-init"),
]