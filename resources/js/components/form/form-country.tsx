import { router } from "@inertiajs/react";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { ToggleGroupItem, ToggleGroupRoot } from "@narsil-ui/components/toggle-group";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import type { OptionData } from "@narsil-ui/types";
import { type ComponentProps } from "react";

type FormCountryProps = ComponentProps<"div"> & {
  countries: OptionData[];
};

function FormCountry({ className, countries, ...props }: FormCountryProps) {
  const { trans } = useTranslator();

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
    <div className={cn("grid gap-1 border-b p-2", className)} {...props}>
      <div className="flex items-center justify-start gap-2 pl-2.5">
        <Icon className="size-4" name="globe" />
        <Heading level="h3" variant="discreet">
          {trans("ui.countries")}
        </Heading>
      </div>
      <ToggleGroupRoot
        defaultValue={[countries[0].value as string]}
        multiple={false}
        orientation="vertical"
        spacing={1}
        value={[value as string]}
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
    </div>
  );
}

export default FormCountry;
