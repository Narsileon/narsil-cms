import { FormEvent } from "react";
import { VisitOptions } from "@inertiajs/core";
import { useForm } from "./form-provider";

export type FormProps = React.ComponentProps<"form"> & {
  options?: Omit<VisitOptions, "data">;
  url: string;
};

function Form({ method = "post", options, url, ...props }: FormProps) {
  const { id, patch, post, put } = useForm();

  function onSubmit(e?: FormEvent) {
    e?.preventDefault();

    switch (method) {
      case "patch":
        patch?.(url, options);
        break;
      case "post":
        post?.(url, options);
        break;
      case "put":
        put?.(url, options);
        break;
    }
  }

  return <form id={id} method={method} onSubmit={onSubmit} {...props} />;
}

export default Form;
