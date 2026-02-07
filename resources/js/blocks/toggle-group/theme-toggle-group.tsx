import { themes, useThemeStore } from "@narsil-cms/stores/theme-store";
import { Icon } from "@narsil-ui/components/icon";
import { ToggleGroupItem, ToggleGroupRoot } from "@narsil-ui/components/toggle-group";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { useRef } from "react";

type ThemeToggleGroupProps = {
  className?: string;
};

function ThemeToggleGroup({ ...props }: ThemeToggleGroupProps) {
  const { trans } = useTranslator();

  const { theme: currentTheme, setTheme } = useThemeStore();

  return (
    <ToggleGroupRoot multiple={false} value={[currentTheme]} {...props}>
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
          <Tooltip tooltip={trans(`themes.${theme}`)}>
            <ToggleGroupItem
              ref={ref}
              size="icon"
              variant="outline"
              value={theme}
              onClick={handleClick}
              key={theme}
            >
              <Icon name={theme === "light" ? "sun" : theme === "dark" ? "moon" : "sun-moon"} />
            </ToggleGroupItem>
          </Tooltip>
        );
      })}
    </ToggleGroupRoot>
  );
}

export default ThemeToggleGroup;
