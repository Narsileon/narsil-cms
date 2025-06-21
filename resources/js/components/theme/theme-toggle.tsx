import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { Moon, Sun } from "lucide-react";
import { useTheme } from "./theme-provider";
import { useTranslationsStore } from "@/stores/translations-store";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

function ThemeToggle() {
  const { setTheme } = useTheme();
  const { trans } = useTranslationsStore();

  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild>
        <Button variant="outline" size="icon">
          <Sun
            className={cn(
              "h-[1.2rem] w-[1.2rem] scale-100 rotate-0 transition-all",
              "dark:scale-0 dark:-rotate-90",
            )}
          />
          <Moon
            className={cn(
              "absolute h-[1.2rem] w-[1.2rem] scale-0 rotate-90 transition-all",
              "dark:scale-100 dark:rotate-0",
            )}
          />
          <span className="sr-only">Toggle theme</span>
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end">
        <DropdownMenuItem onClick={() => setTheme("light")}>
          {trans("ui.light")}
        </DropdownMenuItem>
        <DropdownMenuItem onClick={() => setTheme("dark")}>
          {trans("ui.dark")}
        </DropdownMenuItem>
        <DropdownMenuItem onClick={() => setTheme("system")}>
          {trans("ui.system")}
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  );
}

export default ThemeToggle;
