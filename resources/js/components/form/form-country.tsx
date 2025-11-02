import { router } from "@inertiajs/react";
import { ToggleGroupItem, ToggleGroupRoot } from "@narsil-cms/components/toggle-group";
import { cn } from "@narsil-cms/lib/utils";
import { SelectOption } from "@narsil-cms/types";
import { type ComponentProps } from "react";

type FormCountryProps = Omit<
  ComponentProps<typeof ToggleGroupRoot>,
  "defaultValue" | "onValueChange" | "value" | "type"
> & {
  countries: SelectOption[];
};

function FormCountry({ countries, ...props }: FormCountryProps) {
  const params = new URLSearchParams(window.location.search);

  const value = params.get("country") ?? countries[0]?.value;

  function onValueChange(value: string) {
    router.reload({ data: { country: value } });
  }

  return (
    <ToggleGroupRoot
      defaultValue={countries[0].value as string}
      orientation="vertical"
      value={value as string}
      type="single"
      onValueChange={(value) => onValueChange(value as string)}
      {...props}
    >
      {countries.map((option) => (
        <ToggleGroupItem
          className="flex w-full items-center justify-between pr-2"
          value={option.value as string}
          key={option.value}
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
      ))}
    </ToggleGroupRoot>
  );
}

export default FormCountry;
