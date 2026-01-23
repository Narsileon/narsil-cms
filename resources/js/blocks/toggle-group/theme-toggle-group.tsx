import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { useLocalization } from "@narsil-cms/components/localization";
import { ToggleGroupItem, ToggleGroupRoot } from "@narsil-cms/components/toggle-group";
import { themes, useThemeStore } from "@narsil-cms/stores/theme-store";
import { useRef } from "react";

type ThemeToggleGroupProps = {
  className?: string;
};

function ThemeToggleGroup({ ...props }: ThemeToggleGroupProps) {
  const { trans } = useLocalization();

  const { theme: currentTheme, setTheme } = useThemeStore();

  return (
    <ToggleGroupRoot type="single" value={currentTheme} {...props}>
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
            <Tooltip tooltip={trans(`themes.${theme}`)}>
              <div className="flex size-full items-center justify-center">
                <Icon name={theme === "light" ? "sun" : theme === "dark" ? "moon" : "sun-moon"} />
              </div>
            </Tooltip>
          </ToggleGroupItem>
        );
      })}
    </ToggleGroupRoot>
  );
}

export default ThemeToggleGroup;
