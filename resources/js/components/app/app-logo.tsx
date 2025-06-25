import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";

function AppLogo() {
  return (
    <Link className="text-xl font-bold" href={route("home")}>
      NARSIL
    </Link>
  );
}

export default AppLogo;
