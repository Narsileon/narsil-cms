import { useRef } from "react";

import { Icon } from "@narsil-cms/components/icon";
import {
  ToggleGroupItem,
  ToggleGroupRoot,
} from "@narsil-cms/components/toggle-group";
import { useThemeStore, themes } from "@narsil-cms/stores/theme-store";

type ThemeToggleGroupProps = {
  className?: string;
};

function ThemeToggleGroup({ ...props }: ThemeToggleGroupProps) {
  const { theme, setTheme } = useThemeStore();

  return (
    <ToggleGroupRoot value={theme} type="single" {...props}>
      {themes.map((theme) => {
        const ref = useRef<HTMLButtonElement>(null);

        const handleClick = () => {
          if (!ref.current) {
            return;
          }

          const rect = ref.current.getBoundingClientRect();

          const x = rect.left + rect.width / 2;
          const y = rect.top + rect.height / 2;

          setTheme(theme, { x, y });
        };

        return (
          <ToggleGroupItem
            ref={ref}
            size="icon"
            variant="outline"
            value={theme}
            onClick={handleClick}
            key={theme}
          >
            <Icon
              name={
                theme === "light"
                  ? "sun"
                  : theme === "dark"
                    ? "moon"
                    : "sun-moon"
              }
            />
          </ToggleGroupItem>
        );
      })}
    </ToggleGroupRoot>
  );
}

export default ThemeToggleGroup;
