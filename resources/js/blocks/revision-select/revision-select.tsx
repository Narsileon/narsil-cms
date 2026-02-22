import { router } from "@inertiajs/react";
import type { Revision } from "@narsil-cms/types";
import { Select } from "@narsil-ui/components/select";
import { useMemo } from "react";

type RevisionSelectProps = {
  revisions: Revision[];
};

function RevisionSelect({ revisions }: RevisionSelectProps) {
  const params = new URLSearchParams(window.location.search);

  const revision = params.get("revision") ?? revisions[0]?.uuid;

  const options = useMemo(
    () =>
      revisions.map((r) => {
        return {
          label: `Revision ${r.revision}`,
          value: r.uuid,
        };
      }),
    [revisions],
  );

  function onValueChange(value: string) {
    router.reload({ data: { revision: value } });
  }

  return (
    <Select
      options={options}
      value={revision}
      triggerProps={{
        variant: "secondary",
        className: "w-full",
      }}
      onValueChange={onValueChange}
    />
  );
}

export default RevisionSelect;
