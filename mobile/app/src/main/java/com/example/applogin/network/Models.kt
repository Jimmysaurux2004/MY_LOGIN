package com.example.applogin.network

data class LoginRequest(
    val usuario: String,
    val contrasena: String
)

data class LoginResponse(
    val success: Boolean,
    val usuario: Usuario?
)

data class Usuario(
    val id: Int,
    val nombres: String,
    val correo: String,
    val roles: List<String>
)
