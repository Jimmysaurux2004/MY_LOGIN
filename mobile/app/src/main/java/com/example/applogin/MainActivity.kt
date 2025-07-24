package com.example.applogin

import android.os.Bundle
import android.widget.Toast
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.enableEdgeToEdge
import androidx.compose.foundation.layout.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.input.PasswordVisualTransformation
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import com.example.applogin.network.LoginRequest
import com.example.applogin.network.LoginResponse
import com.example.applogin.network.RetrofitClient
import com.example.applogin.ui.theme.AppLoginTheme
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContent {
            AppLoginTheme {
                Scaffold(modifier = Modifier.fillMaxSize()) { innerPadding ->
                    LoginScreen(
                        modifier = Modifier.padding(innerPadding)
                    ) { usuario, contrasena ->
                        // ✅ Ahora en lugar de imprimir, hacemos login real
                        hacerLogin(usuario, contrasena)
                    }
                }
            }
        }
    }

    // ✅ Esta función llama al backend con Retrofit
    private fun hacerLogin(usuario: String, contrasena: String) {
        val request = LoginRequest(usuario, contrasena)

        RetrofitClient.instance.login(request).enqueue(object : Callback<LoginResponse> {
            override fun onResponse(
                call: Call<LoginResponse>,
                response: Response<LoginResponse>
            ) {
                if (response.isSuccessful) {
                    val body = response.body()
                    if (body?.success == true) {
                        Toast.makeText(
                            this@MainActivity,
                            "✅ Bienvenido ${body.usuario?.nombres}",
                            Toast.LENGTH_LONG
                        ).show()
                    } else {
                        Toast.makeText(
                            this@MainActivity,
                            "❌ Usuario o contraseña incorrectos",
                            Toast.LENGTH_SHORT
                        ).show()
                    }
                } else {
                    Toast.makeText(
                        this@MainActivity,
                        "⚠️ Error en la respuesta del servidor",
                        Toast.LENGTH_SHORT
                    ).show()
                }
            }

            override fun onFailure(call: Call<LoginResponse>, t: Throwable) {
                Toast.makeText(this@MainActivity, "🚨 Error: ${t.message}", Toast.LENGTH_LONG).show()
            }
        })
    }
}

// ✅ Pantalla de Login en Compose
@Composable
fun LoginScreen(
    modifier: Modifier = Modifier,
    onLoginClick: (String, String) -> Unit
) {
    var usuario by remember { mutableStateOf("") }
    var contrasena by remember { mutableStateOf("") }

    Column(
        modifier = modifier
            .fillMaxSize()
            .padding(16.dp),
        verticalArrangement = Arrangement.Center
    ) {
        OutlinedTextField(
            value = usuario,
            onValueChange = { usuario = it },
            label = { Text("Usuario") },
            modifier = Modifier.fillMaxWidth()
        )

        Spacer(modifier = Modifier.height(8.dp))

        OutlinedTextField(
            value = contrasena,
            onValueChange = { contrasena = it },
            label = { Text("Contraseña") },
            modifier = Modifier.fillMaxWidth(),
            visualTransformation = PasswordVisualTransformation()
        )

        Spacer(modifier = Modifier.height(16.dp))

        Button(
            onClick = { onLoginClick(usuario, contrasena) },
            modifier = Modifier.align(Alignment.CenterHorizontally)
        ) {
            Text("Iniciar sesión")
        }
    }
}

@Preview(showBackground = true)
@Composable
fun LoginScreenPreview() {
    AppLoginTheme {
        LoginScreen { _, _ -> }
    }
}
