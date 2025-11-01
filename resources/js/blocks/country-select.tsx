import { router } from "@inertiajs/react";
import { Select } from "@narsil-cms/blocks/fields/select";
import { SelectOption } from "@narsil-cms/types";

type CountrySelectProps = {
  countries: SelectOption[];
};

function CountrySelect({ countries }: CountrySelectProps) {
  const params = new URLSearchParams(window.location.search);

  const country = params.get("country") ?? countries[0]?.value;

  function onValueChange(value: string) {
    router.reload({ data: { country: value } });
  }

  return (
    <Select
      options={countries}
      value={country as string}
      triggerProps={{
        size: "sm",
        variant: "secondary",
      }}
      onValueChange={onValueChange}
    />
  );
}

export default CountrySelect;
