<div style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px;">
        <h1 style="color: #333333; text-align: center;">🎉 Nuevo usuario registrado</h1>
        <h2 style="color: #555555; text-align: center; font-weight: normal;">Money Link App</h2>

        <div style="margin-top: 20px; font-size: 16px; color: #333333;">
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>ID:</strong> {{ $user->id ?? 'N/A' }}</p>
            <!-- Puedes añadir más atributos aquí -->
        </div>

        <div style="margin-top: 30px; text-align: center; font-size: 14px; color: #777777;">
            <p>Money Link App 💼</p>
        </div>
    </div>
</div>