package com.example.applogin.network

import retrofit2.Call
import retrofit2.http.Body
import retrofit2.http.POST

interface ApiService {
    @POST("login.php")
    fun login(@Body request: LoginRequest): Call<LoginResponse>
}
