<template>
<header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <RouterLink class="navbar-brand" to="/">Grass</RouterLink>    

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">


                        <li class="nav-item">
                            <RouterLink class="nav-link active" to="/">Домашняя страница</RouterLink>    
                        </li>

                        <li class="nav-item">
                            <RouterLink class="nav-link" to="/products">Товары</RouterLink>
                        </li>


                        <li class="nav-item">
                            <RouterLink class="nav-link" to="/brands">Бренды</RouterLink>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>
    </header>


</template>