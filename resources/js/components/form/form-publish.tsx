import type { FormType } from "@narsil-cms/types";
import { cn } from "@narsil-ui/lib/utils";
import { Fragment, type ComponentProps } from "react";
import FormElement from "./form-element";

type FormPublishProps = ComponentProps<"div"> & {
  form: FormType;
};

function FormPublish({ className, form, ...props }: FormPublishProps) {
  return (
    <div className={cn("grid gap-2 border-b px-4 pt-2 pb-4", className)} {...props}>
      {form.tabs.map((tab, index) => {
        return (
          <Fragment key={index}>
            {tab.elements?.map((element, index) => {
              return <FormElement {...element} key={index} />;
            })}
          </Fragment>
        );
      })}
    </div>
  );
}

export default FormPublish;
