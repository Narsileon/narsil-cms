import { router } from "@inertiajs/react";
import { ToggleGroupItem, ToggleGroupRoot } from "@narsil-ui/components/toggle-group";
import { cn } from "@narsil-ui/lib/utils";
import type { OptionData } from "@narsil-ui/types";
import { type ComponentProps } from "react";

type FormCountryProps = Omit<
  ComponentProps<typeof ToggleGroupRoot>,
  "defaultValue" | "onValueChange" | "value" | "type"
> & {
  countries: OptionData[];
};

function FormCountry({ countries, ...props }: FormCountryProps) {
  const params = new URLSearchParams(window.location.search);

  const value = params.get("country") ?? countries[0]?.value;

  function onValueChange(value: string) {
    router.get(
      window.location.pathname,
      { country: value },
      {
        preserveState: false,
        preserveScroll: true,
        replace: true,
      },
    );
  }

  return (
    <ToggleGroupRoot
      defaultValue={[countries[0].value as string]}
      multiple={false}
      orientation="vertical"
      spacing={1}
      value={[value as string]}
      {...props}
    >
      {countries.map((option) => {
        return (
          <ToggleGroupItem
            className="flex w-full items-center justify-between pr-2"
            value={option.value as string}
            onClick={() => {
              onValueChange(option.value as string);
            }}
            key={option.value as string}
          >
            <span
              className={cn(
                "relative pl-5 font-normal",
                "before:absolute before:top-1/2 before:left-0 before:-translate-y-1/2",
                "before:size-1.5 before:rounded-full before:bg-constructive",
                option.value === value
                  ? "before:animate-pulse before:bg-constructive"
                  : "before:bg-foreground",
              )}
            >
              {option.label as string}
            </span>
          </ToggleGroupItem>
        );
      })}
    </ToggleGroupRoot>
  );
}

export default FormCountry;
