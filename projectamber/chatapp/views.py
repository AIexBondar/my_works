from authapp.models import User
from django.shortcuts import render, get_object_or_404
from .models import Chat, Contact

def get_last_10_messages(chatId):
    chat = get_object_or_404(Chat, id=chatId)
    return chat.messages.order_by('-timestamp').all()[:10]

def get_user_contact(email):
    user = get_object_or_404(User, email=email)
    return get_object_or_404(Contact, user=user)

def get_current_chat(chatId):
    return get_object_or_404(Chat, id=chatId)

def chat(request):
	return render(request, 'frontend/index.html')