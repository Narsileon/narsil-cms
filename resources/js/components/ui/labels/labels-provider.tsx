import * as React from "react";
import { get } from "lodash";
import { LabelsContext } from "./labels-context";

type LabelsProviderProps = {
  children: React.ReactNode;
  labels: Record<string, string>;
};

const LabelsProvider = ({ children, labels }: LabelsProviderProps) => {
  function getLabel(key: string, fallback?: string | null) {
    return get(labels, key) ?? fallback ?? "No translation found";
  }

  return (
    <LabelsContext.Provider value={{ getLabel: getLabel }}>
      {children}
    </LabelsContext.Provider>
  );
};

export default LabelsProvider;
